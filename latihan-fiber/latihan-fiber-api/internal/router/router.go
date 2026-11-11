package router

import (
	"latihan-fiber-api/internal/handler"
	"latihan-fiber-api/internal/middleware"

	"github.com/gofiber/fiber/v3"
)

func Daftarkan(app *fiber.App) {
	api := app.Group("/api")

	api.Get("/status", func(c fiber.Ctx) error {
		return c.JSON(fiber.Map{
			"sukses": true,
			"pesan":  "API Fiber aktif",
		})
	})

	// Endpoint autentikasi yang bisa diakses publik.
	auth := api.Group("/auth")
	auth.Post("/registrasi", handler.Registrasi)
	auth.Post("/login", handler.Login)

	// Endpoint yang membutuhkan JWT valid.
	terlindungi := api.Group("", middleware.Autentikasi())
	terlindungi.Get("/auth/profil", handler.Profil)

	// Endpoint mahasiswa membutuhkan JWT.
	mahasiswa := terlindungi.Group("/mahasiswa")

	mahasiswa.Get("/", handler.DaftarMahasiswa)
	mahasiswa.Get("/:id", handler.DetailMahasiswa)

	mahasiswa.Post("/", middleware.HanyaPeran("admin", "dosen"), handler.BuatMahasiswa)
	mahasiswa.Put("/:id", middleware.HanyaPeran("admin", "dosen"), handler.PerbaruiMahasiswa)
	mahasiswa.Delete("/:id", middleware.HanyaPeran("admin"), handler.HapusMahasiswa)

	// Pemulihan data hanya dapat dilakukan admin.
	mahasiswa.Post("/:id/pulihkan", middleware.HanyaPeran("admin"), handler.PulihkanMahasiswa)

	// Matakuliah tetap menggunakan API Key.
	matakuliah := api.Group("/matakuliah")
	matakuliah.Use(middleware.KunciApi)

	matakuliah.Get("/", handler.DaftarMatakuliah)
	matakuliah.Post("/", handler.BuatMatakuliah)
	matakuliah.Get("/:id", handler.DetailMatakuliah)
	matakuliah.Put("/:id", handler.PerbaruiMatakuliah)
	matakuliah.Delete("/:id", handler.HapusMatakuliah)

	// Program Studi tetap menggunakan API Key.
	programStudi := api.Group("/program-studi")
	programStudi.Use(middleware.KunciApi)

	programStudi.Get("/", handler.DaftarProgramStudi)
}
