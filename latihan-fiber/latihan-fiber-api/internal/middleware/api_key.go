package middleware

import (
	"os"

	"github.com/gofiber/fiber/v3"
)

func KunciApi(c fiber.Ctx) error {
	apiKey := c.Get("X-Api-Key")
	kunciBenar := os.Getenv("API_KEY")

	if apiKey == "" || apiKey != kunciBenar {
		return fiber.NewError(
			fiber.StatusUnauthorized,
			"API Key tidak valid",
		)
	}

	return c.Next()
}
