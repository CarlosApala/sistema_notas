<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    DB::unprepared(<<<SQL
    CREATE OR REPLACE FUNCTION trg_auditoria_zonas()
    RETURNS TRIGGER AS \$\$
    DECLARE
        v_usuario TEXT;
        v_ip TEXT;
    BEGIN
        -- Obtener usuario e IP desde las variables de sesión
        BEGIN
            v_usuario := current_setting('app.current_user_id', true);
            IF v_usuario IS NULL THEN
                v_usuario := 'sin_usuario';
            END IF;
        EXCEPTION WHEN OTHERS THEN
            v_usuario := 'sin_usuario';
        END;

        BEGIN
            v_ip := current_setting('app.client_ip', true);
            IF v_ip IS NULL THEN
                v_ip := COALESCE(inet_client_addr()::TEXT, '0.0.0.0');
            END IF;
        EXCEPTION WHEN OTHERS THEN
            v_ip := COALESCE(inet_client_addr()::TEXT, '0.0.0.0');
        END;

        IF TG_OP = 'INSERT' THEN
            INSERT INTO auditoria (
                tabla_afectada,
                id_registro,
                tipo_operacion,
                datos_nuevos,
                usuario,
                ip_origen
            )
            VALUES (
                'zonas',
                NEW.id,
                'INSERT',
                row_to_json(NEW)::TEXT,
                v_usuario,
                v_ip
            );
        ELSIF TG_OP = 'UPDATE' THEN
            INSERT INTO auditoria (
                tabla_afectada,
                id_registro,
                tipo_operacion,
                datos_anteriores,
                datos_nuevos,
                usuario,
                ip_origen
            )
            VALUES (
                'zonas',
                NEW.id,
                'UPDATE',
                row_to_json(OLD)::TEXT,
                row_to_json(NEW)::TEXT,
                v_usuario,
                v_ip
            );
        ELSIF TG_OP = 'DELETE' THEN
            INSERT INTO auditoria (
                tabla_afectada,
                id_registro,
                tipo_operacion,
                datos_anteriores,
                usuario,
                ip_origen
            )
            VALUES (
                'zonas',
                OLD.id,
                'DELETE',
                row_to_json(OLD)::TEXT,
                v_usuario,
                v_ip
            );
        END IF;

        RETURN NULL;
    END;
    \$\$ LANGUAGE plpgsql;

    DROP TRIGGER IF EXISTS tr_auditoria_zonas ON zonas;

    CREATE TRIGGER tr_auditoria_zonas
    AFTER INSERT OR UPDATE OR DELETE ON zonas
    FOR EACH ROW
    EXECUTE FUNCTION trg_auditoria_zonas();
    SQL);
}

    public function down()
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS tr_auditoria_zonas ON zonas;
            DROP FUNCTION IF EXISTS trg_auditoria_zonas();
        ');
    }
};
