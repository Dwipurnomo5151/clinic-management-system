<?php

class m240415_234567_fix_user_status_type extends CDbMigration
{
    public function up()
    {
        // Create enum type if not exists
        $this->execute("DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'user_status') THEN
                CREATE TYPE user_status AS ENUM ('aktif', 'nonaktif');
            END IF;
        END$$;");

        // Temporarily change status to allow type conversion
        $this->execute("ALTER TABLE \"user\" ALTER COLUMN status DROP NOT NULL;");
        $this->execute("ALTER TABLE \"user\" ALTER COLUMN status TYPE user_status USING (status::user_status);");
        $this->execute("ALTER TABLE \"user\" ALTER COLUMN status SET NOT NULL;");
        $this->execute("ALTER TABLE \"user\" ALTER COLUMN status SET DEFAULT 'aktif';");
    }

    public function down()
    {
        $this->execute("ALTER TABLE \"user\" ALTER COLUMN status TYPE VARCHAR(255);");
    }
} 