package handler

import (
	"errors"
	"strconv"

	"latihan-fiber-api/internal/model"
	"latihan-fiber-api/internal/repository"

	"github.com/gofiber/fiber/v3"
	"gorm.io/gorm"
)

func DaftarMatakuliah(c fiber.Ctx) error {
	daftar, err := repository.AmbilSemuaMatakuliah()
	if err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal mengambil data"})
	}

	return c.JSON(fiber.Map{"data": daftar})
}

func DetailMatakuliah(c fiber.Ctx) error {
	id, err := strconv.ParseUint(c.Params("id"), 10, 32)
	if err != nil {
		return c.Status(400).JSON(fiber.Map{"pesan": "ID tidak valid"})
	}

	matakuliah, err := repository.AmbilMatakuliahPerId(uint(id))
	if errors.Is(err, gorm.ErrRecordNotFound) {
		return c.Status(404).JSON(fiber.Map{"pesan": "Matakuliah tidak ditemukan"})
	}
	if err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal mengambil data"})
	}

	return c.JSON(fiber.Map{"data": matakuliah})
}

func BuatMatakuliah(c fiber.Ctx) error {
	var input model.Matakuliah
	if err := c.Bind().JSON(&input); err != nil {
		return c.Status(400).JSON(fiber.Map{"pesan": "Format JSON tidak valid"})
	}

	if input.Kode == "" || input.Nama == "" || input.SKS <= 0 || input.Semester <= 0 {
		return c.Status(400).JSON(fiber.Map{"pesan": "Semua field wajib diisi dengan benar"})
	}

	if err := repository.SimpanMatakuliah(&input); err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal menyimpan data"})
	}

	return c.Status(201).JSON(fiber.Map{
		"pesan": "Matakuliah berhasil ditambahkan",
		"data":  input,
	})
}

func PerbaruiMatakuliah(c fiber.Ctx) error {
	id, err := strconv.ParseUint(c.Params("id"), 10, 32)
	if err != nil {
		return c.Status(400).JSON(fiber.Map{"pesan": "ID tidak valid"})
	}

	matakuliah, err := repository.AmbilMatakuliahPerId(uint(id))
	if errors.Is(err, gorm.ErrRecordNotFound) {
		return c.Status(404).JSON(fiber.Map{"pesan": "Matakuliah tidak ditemukan"})
	}
	if err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal mengambil data"})
	}

	if err := c.Bind().JSON(&matakuliah); err != nil {
		return c.Status(400).JSON(fiber.Map{"pesan": "Format JSON tidak valid"})
	}

	matakuliah.ID = uint(id)
	if err := repository.PerbaruiMatakuliah(&matakuliah); err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal memperbarui data"})
	}

	return c.JSON(fiber.Map{
		"pesan": "Matakuliah berhasil diperbarui",
		"data":  matakuliah,
	})
}

func HapusMatakuliah(c fiber.Ctx) error {
	id, err := strconv.ParseUint(c.Params("id"), 10, 32)
	if err != nil {
		return c.Status(400).JSON(fiber.Map{"pesan": "ID tidak valid"})
	}

	matakuliah, err := repository.AmbilMatakuliahPerId(uint(id))
	if errors.Is(err, gorm.ErrRecordNotFound) {
		return c.Status(404).JSON(fiber.Map{"pesan": "Matakuliah tidak ditemukan"})
	}
	if err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal mengambil data"})
	}

	if err := repository.HapusMatakuliah(&matakuliah); err != nil {
		return c.Status(500).JSON(fiber.Map{"pesan": "Gagal menghapus data"})
	}

	return c.JSON(fiber.Map{"pesan": "Matakuliah berhasil dihapus"})
}
