<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Force reload session data to show the new pictures!
unset($_SESSION['menu_items']);

if (!isset($_SESSION['menu_items'])) {
    // =====================================================================
    // CUSTOMIZE YOUR FOOD ITEMS HERE!
    // =====================================================================
    // You can change the 'name', 'description', 'price', and 'image' below.
    // If you want to use your own downloaded images:
    // 1. Save the picture in your 'images' folder (e.g. images/my-adobo.jpg)
    // 2. Change the 'image' property below to point to it: 'image' => 'images/my-adobo.jpg'
    // =====================================================================
    $_SESSION['menu_items'] = [
        1 => [
            'id' => 1,
            'name' => 'Chicken Adobo Rice',
            'category' => 'Lunch',
            'price' => 55,
            'badge' => 'Today\'s Special',
            'description' => 'A warm rice meal with classic chicken adobo, a Filipino favorite.',
            'ingredients' => 'Rice, chicken, soy sauce, vinegar, garlic',
            'image' => 'images/adobo_rice.png',
            'featured' => true,
            'sold_out' => false,
        ],
        2 => [
            'id' => 2,
            'name' => 'Tapsilog Special',
            'category' => 'Breakfast',
            'price' => 45,
            'badge' => 'Available',
            'description' => 'A filling breakfast plate with beef tapa, sinangag (garlic rice), and itlog (egg).',
            'ingredients' => 'Beef tapa, garlic rice, egg, tomatoes',
            'image' => 'images/tapsilog.png',
            'featured' => true,
            'sold_out' => false,
        ],
        3 => [
            'id' => 3,
            'name' => 'Pancit Canton Fiesta',
            'category' => 'Lunch',
            'price' => 50,
            'badge' => 'Available',
            'description' => 'Savory stir-fried noodles with vegetables and sliced pork or chicken.',
            'ingredients' => 'Noodles, chicken bits, carrots, cabbage',
            'image' => 'images/pancit_canton.png',
            'featured' => false,
            'sold_out' => false,
        ],
        4 => [
            'id' => 4,
            'name' => 'Cold Calamansi Juice',
            'category' => 'Drinks',
            'price' => 25,
            'badge' => 'Available',
            'description' => 'A refreshing cold drink with a clean citrus taste, perfect for hot afternoons.',
            'ingredients' => 'Calamansi, water, ice, sugar/honey',
            'image' => 'images/calamansi_juice.png',
            'featured' => true,
            'sold_out' => false,
        ],
        5 => [
            'id' => 5,
            'name' => 'Lumpiang Shanghai Box',
            'category' => 'Snacks',
            'price' => 30,
            'badge' => 'Sold Out',
            'description' => 'A quick bite packed with crunchy fried spring rolls.',
            'ingredients' => 'Pork, wrapper, carrots, sweet chili dip',
            'image' => 'images/lumpiang_shanghai.png',
            'featured' => false,
            'sold_out' => true,
        ],
        6 => [
            'id' => 6,
            'name' => 'Halo-Halo Special',
            'category' => 'Desserts',
            'price' => 35,
            'badge' => 'Available',
            'description' => 'The ultimate Filipino cold dessert mixed with shaved ice, beans, jellies, and topped with leche flan.',
            'ingredients' => 'Shaved ice, milk, ube, leche flan, sago, beans',
            'image' => 'images/halo_halo.png',
            'featured' => true,
            'sold_out' => false,
        ],
    ];
}

if (!isset($_SESSION['current_user'])) {
    $_SESSION['current_user'] = null;
}

if (!function_exists('kantoeat_menu_items')) {
    function kantoeat_menu_items(): array {
        return $_SESSION['menu_items'] ?? [];
    }

    function kantoeat_get_item($id): ?array {
        $items = kantoeat_menu_items();
        return $items[$id] ?? null;
    }

    function kantoeat_next_id(): int {
        $items = kantoeat_menu_items();
        return empty($items) ? 1 : (max(array_keys($items)) + 1);
    }

    function kantoeat_save_item(array $item): void {
        $_SESSION['menu_items'][$item['id']] = $item;
    }

    function kantoeat_delete_item(int $id): void {
        if (isset($_SESSION['menu_items'][$id])) {
            unset($_SESSION['menu_items'][$id]);
        }
    }

    function kantoeat_price($price): string {
        return '₱' . number_format((float)$price, 2);
    }

    function kantoeat_current_user(): ?array {
        return $_SESSION['current_user'] ?? null;
    }

    function kantoeat_is_logged_in(): bool {
        return !empty($_SESSION['current_user']);
    }

    function kantoeat_is_admin(): bool {
        return !empty($_SESSION['current_user']) && (($_SESSION['current_user']['role'] ?? '') === 'admin');
    }

    function kantoeat_require_login(): void {
        if (!kantoeat_is_logged_in()) {
            header('Location: login.php');
            exit;
        }
    }

    function kantoeat_require_admin(): void {
        if (!kantoeat_is_admin()) {
            header('Location: ../login.php?role=admin');
            exit;
        }
    }

    function kantoeat_set_user(array $user): void {
        $_SESSION['current_user'] = $user;
    }
}
