<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Schema;

class SubAppSyncDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync {key} {params}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync database records among apps';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment($this->description);
        extract($this->argument());
        $availableKeys = [
            'seed', 'clean',
        ];
        if (!in_array($key, $availableKeys)) {
            $this->warn("Your {key=$key} doesn't available ... exiting");
            $this->info("available keys: ".implode(', ', $availableKeys));
            die;
        }
        $this->warn('executing '.$key.' key ...');
        $tables = [
            'users', 'password_resets', 'roles', 'permissions',
            'permission_role', 'role_user',
        ];
        foreach ($tables as $i => $value) {
            $this->$key($value, $params, $i===0?true:false);
        }
    }

    private function clean($table, $target, $head = false) {
        $infos = [
            'table' => $table,
            'exists' => 'false',
            'dropped' => 'false',
        ];
        $result = Schema::connection($target)->hasTable($table);
        $infos['exists'] = bool_val($result);
        if ($result) {
            DB::unprepared("DROP TABLE $target.$table");
            $infos['dropped'] = bool_val(
                !Schema::connection($target)->hasTable($table)
            );
        }
        if ($head) {
            $this->error(vsprintf("%-18s\t%-8s\t%-8s", array_keys($infos)));
        }
        print vsprintf("%-18s\t%-8s\t%-8s", $infos);
        echo "\n";
    }

    private function seed($table, $target, $head = false) {
        $infos = [
            'table' => $table,
            'exists' => 'false',
            'created' => 'false',
            'inserted' => 'false',
        ];
        $master = 'user';
        $result = Schema::connection($target)->hasTable($table);
        $infos['exists'] = bool_val($result);
        if (!$result) {
            DB::unprepared(
                "CREATE TABLE $target.$table LIKE $master.$table"
            );
            $infos['created'] = bool_val(
                Schema::connection($target)->hasTable($table)
            );
            $infos['inserted'] = bool_val(DB::unprepared(
                "INSERT INTO $target.$table SELECT * FROM $master.$table"
            ));
        }
        if ($head) {
            $this->error(vsprintf("%-18s\t%-8s\t%-8s\t%-8s", array_keys($infos)));
        }
        print vsprintf("%-18s\t%-8s\t%-8s\t%-8s", $infos);
        echo "\n";
    }
}
