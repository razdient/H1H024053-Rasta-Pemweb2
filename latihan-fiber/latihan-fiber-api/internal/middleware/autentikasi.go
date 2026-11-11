package middleware

import (
	"strconv"
	"strings"

	"github.com/gofiber/fiber/v3"

	"latihan-fiber-api/internal/auth"
	"latihan-fiber-api/internal/config"
)

// Autentikasi memeriksa JWT dari header Authorization.
func Autentikasi() fiber.Handler {
	return func(c fiber.Ctx) error {
		header := c.Get("Authorization")

		if header == "" {
			return fiber.NewError(fiber.StatusUnauthorized, "Token tidak ditemukan")
		}

		bagian := strings.SplitN(header, " ", 2)

		if len(bagian) != 2 || bagian[0] != "Bearer" {
			return fiber.NewError(fiber.StatusUnauthorized, "Format token harus Bearer <token>")
		}

		konfigurasi := config.Muat()

		klaim, err := auth.PeriksaToken(bagian[1], konfigurasi.JwtSecret)
		if err != nil {
			return fiber.NewError(fiber.StatusUnauthorized, "Token tidak valid atau kedaluwarsa")
		}

		idPengguna, err := strconv.ParseUint(klaim.Subject, 10, 64)
		if err != nil {
			return fiber.NewError(fiber.StatusUnauthorized, "ID pengguna dalam token tidak valid")
		}

		c.Locals("id_pengguna", uint(idPengguna))
		c.Locals("peran", klaim.Peran)

		return c.Next()
	}
}

// HanyaPeran membatasi akses berdasarkan peran pengguna.
func HanyaPeran(peranDiizinkan ...string) fiber.Handler {
	return func(c fiber.Ctx) error {
		peran := c.Locals("peran")

		for _, peranIzin := range peranDiizinkan {
			if peran == peranIzin {
				return c.Next()
			}
		}

		return fiber.NewError(fiber.StatusForbidden, "Anda tidak memiliki hak akses")
	}
}
