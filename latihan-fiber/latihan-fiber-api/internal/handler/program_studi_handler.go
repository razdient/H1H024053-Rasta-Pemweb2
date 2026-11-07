package handler

import (
	"latihan-fiber-api/internal/repository"

	"github.com/gofiber/fiber/v3"
)

func DaftarProgramStudi(c fiber.Ctx) error {
	daftar, err := repository.AmbilProgramStudi()
	if err != nil {
		return c.Status(500).JSON(fiber.Map{
			"pesan": "Gagal mengambil data program studi",
		})
	}

	return c.JSON(fiber.Map{
		"data": daftar,
	})
}
