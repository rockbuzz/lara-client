<?php

namespace Rockbuzz\LaraClient\Commands;

use Illuminate\Console\Command;
use Rockbuzz\LaraClient\Models\Client;
use Rockbuzz\LaraClient\StrGenerate;

class CreateClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:create {name : Client name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Client to access API';

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
        \DB::beginTransaction();
        try {
            $name = $this->argument('name');
            $client = Client::create([
                'name' => $name,
                'public_key' => StrGenerate::publicKey(),
                'secret_key' => StrGenerate::secretKey()
            ]);

            $headers = [
                'ID', 
                'Name', 
                'Public Key', 
                'Secret Key',
                'Start Access',
                'End Access',
                'Limit Access',
                'Active'
            ];

            $data = [
                [
                    'id' => $client->id,
                    'name' => $client->name,
                    'publicKey' => $client->publicKey,
                    'secretKey' => $client->secretKey,
                    'start_access' => $client->start_access,
                    'end_access' => 'undefined',
                    'limit_access' => 'undefined',
                    'active' => 'yes'
                ]
            ];

            \DB::commit();

            $this->table($headers, $data);
            
        } catch (\Exception $exception) {
            \DB::rollback();
            $this->error($exception->getMessage());
        }
    }

    protected function tableDonNotExist($table)
    {
        return ! \Illuminate\Support\Facades\Schema::hasTable($table);
    }

    protected function showTableDetails($table)
    {
        $columns = \Illuminate\Support\Facades\DB::select("DESC {$table}");
        $headers = [
            'Field', 'Type', 'Null', 'Key', 'Default', 'Extra',
        ];
        $rows = collect($columns)->map(function ($column) {
            return get_object_vars($column);
        });
        $this->table($headers, $rows);
    }
}
