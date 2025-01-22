<?php

namespace App\Http\Service;

use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Firefox\FirefoxProfile;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

ini_set('max_execution_time', 18000);

class ParsePlayTechOneLogin
{

	private $path = '';
	private $reportUrl = '';
	private $url = '';
	private $seleniumUrl = 'http://localhost:4444';
	private $waitTimeout = 18000;

    private $userName = '';

    private $password = '';

    private $short_timeout = 2;
    private $long_timeout = 6;

    public function __construct(string $imsUser,string $imsPassword,string $path,string $reportUrl, string $url = '#', int $waitTimeout = 18000, string $seleniumUrl = 'http://localhost:4444')
    {

        $this->reportUrl = $reportUrl;
        $this->url = $url;
        $this->waitTimeout = $waitTimeout;
        $this->seleniumUrl = $seleniumUrl;

        if (!file_exists($path)) {
			mkdir($path,0775);
		}

        if (!file_exists($path)) {
            throw new \Exception('Path does not exist');
        }

		$this->path = $path;
		
		$this->userName = $imsUser;
        $this->password = $imsPassword;
        
    }

    public function handle(array $users)
    {
        try {
            $driver = $this->setupBrowser();
            $driver->manage()->timeouts()->implicitlyWait($this->waitTimeout);

            $this->login($driver);

            $this->goToReportPage($driver,$users);
            $this->loadReport($driver);

        } catch (\Exception $exception) {
            echo ($exception->getMessage());
        }
    }

    private function setupBrowser(): RemoteWebDriver
    {
        $profile = new FirefoxProfile();
        $firefoxOptions = new FirefoxOptions();
		
        $profile->setPreference('browser.download.folderList', 2);
        $profile->setPreference('browser.helperApps.neverAsk.saveToDisk', 'text/plain');
        $profile->setPreference('browser.download.dir', $this->path);
        
		$firefoxOptions->addArguments(['--headless', '--disable-gpu', 'profile.default_content_settings.popups=true']);
		
		$cap = DesiredCapabilities::firefox();
        $firefoxOptions->setProfile($profile);

        $cap->setCapability(FirefoxOptions::CAPABILITY, $firefoxOptions);

        return RemoteWebDriver::create($this->seleniumUrl, $cap);
    }

    private function login(RemoteWebDriver $driver): void
    {
        $driver->get($this->url);

		$driver->findElement(WebDriverBy::id('username')) // find search input element
        ->sendKeys($this->userName); // fill the search box
        $driver->findElement(WebDriverBy::id('password')) // find search input element
        ->sendKeys($this->password);
        $driver->findElement(WebDriverBy::id('password'))->submit();
		
        sleep(20);
		
	}

    private function goToReportPage(RemoteWebDriver $driver, array $users): void
    {
        $driver->get($this->reportUrl);

        $this->loadReport($driver);

        foreach ($users as $user) {
            
			echo $user."\n";
			
            $this->setNameAndLoad($driver, $user);

        }
    }

    private function loadReport(RemoteWebDriver $driver, string $startDate = '2024-07-01 00:00:00', string $endDate = '2024-07-31 23:59:59'): void
    {
        $driver->switchTo()->frame($driver->findElement(WebDriverBy::cssSelector('#main-content > iframe:nth-child(3)')));

        $driver->findElement(WebDriverBy::id('moveAllToSelected')) // select all fields
        ->click();

        $driver->findElement(WebDriverBy::xpath('//*[@id="input-85"]')) // open date range
        ->sendKeys(WebDriverKeys::CONTROL . 'a')->sendKeys(WebDriverKeys::BACKSPACE)->sendKeys($startDate);

        $driver->findElement(WebDriverBy::xpath('//*[@id="input-90"]')) // open date range
        ->sendKeys(WebDriverKeys::CONTROL . 'a')->sendKeys(WebDriverKeys::BACKSPACE)->sendKeys($endDate);

        sleep(1);

    }

    private function setNameAndLoad(RemoteWebDriver $driver, string $userName = 'olivka'): void
    {
        $driver->findElement(WebDriverBy::id('username_Reporting___Player_wallet_transactions_inputField'))->clear() // username
        ->sendKeys($userName);


        $el = WebDriverBy::xpath('//button[.//span[contains(text(), "CSV")]]');

        $driver->findElement($el)->click();
        sleep($this->short_timeout);

        while (!$driver->findElement($el)->isEnabled()) {
            sleep($this->long_timeout);
        }
    }
}
