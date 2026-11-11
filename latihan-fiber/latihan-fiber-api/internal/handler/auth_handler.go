package handler

import (
	"github.com/gofiber/fiber/v3"
	"golang.org/x/crypto/bcrypt"

	"latihan-fiber-api/internal/auth"
	"latihan-fiber-api/internal/config"
	"latihan-fiber-api/internal/model"
	"latihan-fiber-api/internal/validasi"
)

// Registrasi membuat akun pengguna baru.
func Registrasi(c fiber.Ctx) error {
	var permintaan PermintaanRegistrasi

	if err := c.Bind().Body(&permintaan); err != nil {
		return fiber.NewError(fiber.StatusBadRequest, "Format body tidak valid")
	}

	galat := validasi.Periksa(permintaan)
	if galat != nil {
		return c.Status(fiber.StatusUnprocessableEntity).JSON(fiber.Map{
			"sukses": false,
			"pesan":  "Data registrasi tidak valid",
			"galat":  galat,
		})
	}

	hash, err := bcrypt.GenerateFromPassword(
		[]byte(permintaan.KataSandi),
		bcrypt.DefaultCost,
	)
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, "Gagal memproses kata sandi")
	}

	pengguna := model.Pengguna{
		Nama:      permintaan.Nama,
		Email:     permintaan.Email,
		KataSandi: string(hash),
		Peran:     "mahasiswa",
	}

	if err := config.DB.Create(&pengguna).Error; err != nil {
		return fiber.NewError(fiber.StatusUnprocessableEntity, "Email sudah terdaftar atau data gagal disimpan")
	}

	return c.Status(fiber.StatusCreated).JSON(fiber.Map{
		"sukses": true,
		"pesan":  "Registrasi berhasil",
		"data":   pengguna,
	})
}

// Login memeriksa kredensial dan menerbitkan JWT.
func Login(c fiber.Ctx) error {
	var permintaan PermintaanLogin

	if err := c.Bind().Body(&permintaan); err != nil {
		return fiber.NewError(fiber.StatusBadRequest, "Format body tidak valid")
	}

	galat := validasi.Periksa(permintaan)
	if galat != nil {
		return c.Status(fiber.StatusUnprocessableEntity).JSON(fiber.Map{
			"sukses": false,
			"pesan":  "Data login tidak valid",
			"galat":  galat,
		})
	}

	var pengguna model.Pengguna

	err := config.DB.Where("email = ?", permintaan.Email).First(&pengguna).Error
	if err != nil {
		return fiber.NewError(fiber.StatusUnauthorized, "Email atau kata sandi salah")
	}

	err = bcrypt.CompareHashAndPassword(
		[]byte(pengguna.KataSandi),
		[]byte(permintaan.KataSandi),
	)
	if err != nil {
		return fiber.NewError(fiber.StatusUnauthorized, "Email atau kata sandi salah")
	}

	konfigurasi := config.Muat()

	token, err := auth.TerbitkanToken(
		pengguna.ID,
		pengguna.Peran,
		konfigurasi.JwtSecret,
		konfigurasi.JwtTtlMenit,
	)
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, "Gagal membuat token")
	}

	return c.JSON(fiber.Map{
		"sukses": true,
		"pesan":  "Login berhasil",
		"token":  token,
	})
}

// Profil menampilkan data pengguna yang sedang login.
func Profil(c fiber.Ctx) error {
	idPengguna := c.Locals("id_pengguna")

	var pengguna model.Pengguna

	if err := config.DB.First(&pengguna, idPengguna).Error; err != nil {
		return fiber.NewError(fiber.StatusNotFound, "Pengguna tidak ditemukan")
	}

	return c.JSON(fiber.Map{
		"sukses": true,
		"data":   pengguna,
	})
}
