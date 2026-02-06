<?php

namespace App\Helpers;

use App\Models\Profile;

class PseudoGenerator
{
    /**
     * List of random words to use in pseudo generation
     */
    private static array $words = [
        'Cool', 'Swift', 'Brave', 'Smart', 'Wise', 'Bold', 'Fast', 'Epic',
        'Star', 'Ninja', 'Tiger', 'Eagle', 'Wolf', 'Lion', 'Bear', 'Hawk',
        'Fire', 'Storm', 'Thunder', 'Shadow', 'Light', 'Dark', 'Frost', 'Blaze',
        'Knight', 'Warrior', 'Hunter', 'Ranger', 'Mage', 'Sage', 'Hero', 'Legend',
        'Dragon', 'Phoenix', 'Titan', 'Giant', 'Wizard', 'Master', 'Chief', 'King',
        'Queen', 'Prince', 'Duke', 'Lord', 'Lady', 'Baron', 'Count', 'Royal',
        'Cosmic', 'Mystic', 'Magic', 'Power', 'Force', 'Energy', 'Vibe', 'Wave',
        'Cyber', 'Tech', 'Digital', 'Pixel', 'Neon', 'Retro', 'Ultra', 'Mega',
        'Super', 'Hyper', 'Turbo', 'Nitro', 'Rocket', 'Jet', 'Flash', 'Sonic',
        'Alpha', 'Beta', 'Gamma', 'Delta', 'Omega', 'Prime', 'Elite', 'Pro',
    ];

    /**
     * Generate a unique pseudo for a user
     * Format: firstname + random word + 4 digits
     * Example: JohnCool1234
     *
     * @param string $firstName
     * @param int $maxAttempts Maximum number of attempts to generate a unique pseudo
     * @return string
     */
    public static function generate(string $firstName, int $maxAttempts = 10): string
    {
        // Clean the first name (remove spaces, special characters)
        $cleanFirstName = preg_replace('/[^a-zA-Z0-9]/', '', $firstName);
        $cleanFirstName = ucfirst(strtolower($cleanFirstName));

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            // Get a random word
            $randomWord = self::$words[array_rand(self::$words)];
            
            // Generate 4 random digits
            $randomDigits = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            
            // Combine to create pseudo
            $pseudo = $cleanFirstName . $randomWord . $randomDigits;
            
            // Check if this pseudo is unique
            if (!Profile::where('pseudo', $pseudo)->exists()) {
                return $pseudo;
            }
        }

        // If we couldn't generate a unique pseudo after max attempts,
        // add a timestamp to ensure uniqueness
        $timestamp = substr((string)time(), -5);
        $randomWord = self::$words[array_rand(self::$words)];
        return $cleanFirstName . $randomWord . $timestamp;
    }
}
