<?php

namespace Src\Common\Presentation\CLI;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CreateSubDomainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:subdomain {subdomain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the provided PowerShell script';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $remoteServer = "159.223.77.161";
        $remoteUsername = "root";
        $domainName = "tiggiekids.com";

        // Get the subdomain name as an argument
        $subdomainName = $this->argument('subdomain');

        // Construct the Plesk CLI command to create the subdomain
        $command = "plesk bin subdomain --create $subdomainName -domain $domainName";

        // Construct the SSH command with the Plesk CLI command
        $sshCommand = "ssh $remoteUsername@$remoteServer \"$command\"";

        // Execute the SSH command
        $output = shell_exec($sshCommand);

        Log::info("Created Subdomain...");
        // Output the result
        $this->info($output);
    }
}
