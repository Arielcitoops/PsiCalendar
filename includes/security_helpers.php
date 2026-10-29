<?php
/*
 * Helpers compartidos de seguridad.
 * Incluir después de functions.php cuando se migren los formularios.
 */

function psi_escape($value): string {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function psi_csrf_token(): string {
    if (empty($_SESSION['psi_csrf_token'])) {
        $_SESSION['psi_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['psi_csrf_token'];
}

function psi_csrf_valid($token): bool {
    return is_string($token)
        && isset($_SESSION['psi_csrf_token'])
        && hash_equals($_SESSION['psi_csrf_token'], $token);
}

/*
 * Requiere una sesión autenticada y un rol explícitamente permitido.
 * La autorización sobre cada paciente/recurso debe verificarse por separado.
 */
function psi_require_role(string ...$allowedRoles): void {
    if (($_SESSION['loggedin'] ?? false) !== true || empty($_SESSION['id'])) {
        header('Location: login.php');
        exit;
    }

    $role = (string) ($_SESSION['role'] ?? 'paciente');
    if (!in_array($role, $allowedRoles, true)) {
        http_response_code(403);
        exit('No tienes permiso para acceder a este recurso.');
    }
}
?>
