# Decisiones de arquitectura — PsiCalendar

## Alcance inicial

- País de operación inicial: Ecuador.
- Modelo de atención: psicólogos independientes, cada uno con su propia cartera.
- Plataforma inicial: web adaptable a móvil; valorar PWA después de estabilizar autenticación y permisos.
- Backend inicial: PHP y MySQL/MariaDB, evitando una reescritura tecnológica antes de auditar la aplicación existente.
- Los registros de seguimiento emocional del paciente y las notas clínicas del profesional son recursos distintos y tienen permisos diferentes.

## Modelo de permisos

### Paciente
- Puede crear y consultar sus propios registros emocionales.
- Puede consultar las relaciones profesionales vinculadas a su cuenta y el estado de los consentimientos.
- No puede consultar notas clínicas privadas.
- Puede conceder o revocar el consentimiento para compartir sus registros de seguimiento.

### Psicólogo independiente
- Puede gestionar su perfil profesional y su cartera.
- Solo puede consultar registros emocionales de un paciente cuando existe una relación activa, el permiso de la relación está habilitado y hay consentimiento vigente.
- Solo puede leer o editar notas clínicas que haya escrito como autor.
- No obtiene acceso a la cuenta ni a los registros de pacientes por conocer su identificador.

### Administrador técnico
- Administra configuración y cuentas según funciones expresamente autorizadas.
- No debe tener acceso ordinario al contenido de diarios emocionales ni notas clínicas. Las intervenciones excepcionales deben justificarse, limitarse y auditarse.

## Reglas de autorización obligatorias

La interfaz no es una barrera de seguridad. Toda comprobación se realiza en el servidor en cada solicitud, incluso si el usuario conoce una URL o un identificador.

Para leer registros emocionales como psicólogo deben cumplirse simultáneamente:
1. Sesión autenticada.
2. Cuenta con rol de psicólogo y perfil profesional activo/verificado.
3. Relación con el paciente en estado `activa`.
4. `puede_ver_registros = 1`.
5. Consentimiento de seguimiento vigente y no revocado.
6. El recurso solicitado pertenece al paciente de esa relación.

Para notas clínicas:
1. Sesión autenticada como psicólogo.
2. Relación profesional válida con el paciente.
3. El autor de la nota coincide con el usuario autenticado.
4. La consulta y la modificación se limitan por `autor_psicologo_id` y `relacion_id`; no confiar solo en el ID de la nota.

Las revocaciones deben aplicarse de inmediato a futuras lecturas. No eliminan automáticamente los datos: conservación, exportación, eliminación y obligaciones profesionales deben definirse según la normativa aplicable.

## Modelo de datos inicial

- `usuarios`: identidad y rol; conserva compatibilidad con el esquema actual.
- `perfiles_profesionales`: datos profesionales separados de la cuenta.
- `registros_diarios`: registros emocionales propiedad del paciente; se conserva la tabla actual.
- `relaciones_terapeuticas`: vínculo entre un psicólogo independiente y un paciente, estado y permiso de seguimiento.
- `consentimientos`: alcance, versión de política, concesión y revocación.
- `notas_clinicas`: notas privadas con autor profesional explícito.
- `auditoria_seguridad`: eventos de acceso y cambios de permisos, sin registrar el contenido de notas o diarios.

La migración inicial está en `database/migrations/001_modelo_seguimiento_profesional.sql`. Es aditiva: no borra los registros existentes y no crea relaciones ni consentimientos automáticamente.

## Seguridad y privacidad

- No utilizar datos reales de pacientes en desarrollo, pruebas o capturas.
- Separar secretos de configuración y variables de entorno; no mostrar detalles de errores de base de datos al usuario.
- Usar consultas preparadas, validación en servidor, escape HTML de salida, protección CSRF, cookies de sesión seguras y regeneración de ID de sesión.
- Auditar accesos denegados, cambios de relación y consentimiento sin guardar contenido sensible en logs.
- Definir política de retención, copias de seguridad cifradas, restauración probada, respuesta ante incidentes y control de acceso operativo.
- Antes del despliegue en Ecuador, confirmar obligaciones legales y profesionales aplicables, base jurídica del tratamiento, aviso de privacidad, derechos de titulares, plazos de conservación y contratos con proveedores.

## Secuencia de implementación

1. Revisar y corregir autenticación, sesión, validación y salida HTML.
2. Probar la migración en una copia de desarrollo y verificar compatibilidad con la versión real de MySQL/MariaDB.
3. Implementar funciones centralizadas de autorización en backend.
4. Crear flujo explícito de invitación/vinculación y consentimiento.
5. Habilitar notas clínicas con aislamiento por autor.
6. Añadir pruebas negativas de acceso entre pacientes y profesionales.
7. Modernizar interfaz y, después, valorar PWA.

## Límites de la primera migración

La migración crea la estructura de datos, pero no implementa por sí sola controles de autorización ni convierte cuentas existentes en profesionales. Todas las cuentas actuales quedan como `paciente` por defecto. La verificación y promoción de profesionales debe realizarse de forma manual y controlada. Ejecutar primero en desarrollo y hacer una copia de seguridad.
