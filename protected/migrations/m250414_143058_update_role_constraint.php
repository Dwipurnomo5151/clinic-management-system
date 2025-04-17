<?php

class m250414_143058_update_role_constraint extends CDbMigration
{
    public function up()
    {
        // Drop existing constraint
        $this->execute('ALTER TABLE "user" DROP CONSTRAINT IF EXISTS user_role_check');
        
        // Update existing data
        $this->execute('UPDATE "user" SET role = \'petugas_pendaftaran\' WHERE role = \'pendaftaran\'');
        
        // Add new constraint with updated values
        $this->execute('ALTER TABLE "user" ADD CONSTRAINT user_role_check CHECK (role IN (\'admin\', \'petugas_pendaftaran\', \'dokter\', \'kasir\'))');
    }

    public function down()
    {
        // Drop new constraint
        $this->execute('ALTER TABLE "user" DROP CONSTRAINT IF EXISTS user_role_check');
        
        // Update data back to old values
        $this->execute('UPDATE "user" SET role = \'pendaftaran\' WHERE role = \'petugas_pendaftaran\'');
        
        // Restore old constraint
        $this->execute('ALTER TABLE "user" ADD CONSTRAINT user_role_check CHECK (role IN (\'admin\', \'pendaftaran\', \'dokter\', \'kasir\'))');
    }
} 