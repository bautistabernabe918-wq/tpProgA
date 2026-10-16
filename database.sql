-- Estructura de la base de datos `mi_proyecto_db`

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserción de usuarios iniciales con contraseña hasheada (BCrypt):
-- usuario: fcytuader  / pass: programacionavanzada
-- usuario: admin      / pass: admin
INSERT INTO `usuarios` (`usuario`, `password`) VALUES
('fcytuader', '$2y$10$buM94KlpM.Uki7xNYe1boux2g2g2U77yob5nEdrQyZKqT7OvIV2Wa'),
('admin', '$2y$10$So2GXtGCFhFY..MpKVFJrOyoK6sOaMIZ/0niRJ/qWU0gGRsnjhYOG')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);
