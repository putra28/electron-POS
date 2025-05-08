<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_login_petugas;

            CREATE PROCEDURE sp_login_petugas(
                IN p_contact_petugas VARCHAR(255),
                IN p_password_petugas VARCHAR(255)
            )
            BEGIN
                DECLARE v_password_db VARCHAR(255);
                DECLARE v_status_user ENUM('aktif', 'non-aktif');
                DECLARE v_id_user INT;
                DECLARE v_keterangan VARCHAR(100);

                -- Cek apakah contact ditemukan
                SELECT
                    id_user,
                    password_user,
                    status_user
                INTO
                    v_id_user,
                    v_password_db,
                    v_status_user
                FROM
                    tb_users
                WHERE
                    contact_user = p_contact_petugas
                LIMIT 1;

                -- Jika tidak ditemukan
                IF v_id_user IS NULL THEN
                    SELECT 'Contact tidak ditemukan' AS keterangan;
                ELSE
                    -- Cek password
                    IF v_password_db = SHA2(p_password_petugas, 256) THEN
                        -- Cek status aktif
                        IF v_status_user = 'aktif' THEN
                            -- Login berhasil
                            SELECT
                                id_user,
                                nama_user,
                                contact_user,
                                role_user,
                                status_user,
                                gambar_user,
                                created_at,
                                updated_at,
                                'Login berhasil' AS keterangan
                            FROM tb_users
                            WHERE id_user = v_id_user;
                        ELSE
                            -- Akun non-aktif
                            SELECT 'Akun non-aktif' AS keterangan;
                        END IF;
                    ELSE
                        -- Password salah
                        SELECT 'Password salah' AS keterangan;
                    END IF;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_login_petugas;");
    }
};
