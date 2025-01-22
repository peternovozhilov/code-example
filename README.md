# IMS-scraping

This is an example of IMS scraping using Selenium WebDriver with PHP 8.3 and the Firefox WebDriver in headless mode.
@see classes/ParsePlayTechOneLogin.php

Please remove the --headless option and test step-by-step at least once.
You can set up and use ChromeDriver for Windows instead.
I will add this option for you in the next update.

## **Class: ParsePlayTechOneLogin**
### **Properties**

|**Property**|**Type**|**Description**|
| :-: | :-: | :-: |
|$path|string|Directory path to save reports.|
|$userName|string|IMS username for login.|
|$password|string|IMS password for login.|
|$reportUrl|string|Base URL for accessing reports.|
|$url|string|URL for IMS login page.|
|$seleniumUrl|string|Selenium WebDriver URL.|
|$tmpPath|string|Temporary directory for downloads.|
|$waitTimeout|int|Timeout duration for waiting operations.|
|$seleniumUrl|string|Url for Selenium Web Driver.|


### **Methods**
#### **handle(array $users) : void**
- Handle the whole process
#### **setupBrowser() : RemoteWebDriver**
- Configures a Firefox browser profile for downloading files.
- Returns an initialized RemoteWebDriver instance.
#### **login(RemoteWebDriver $driver) : void**
- Navigates to the login page and authenticates the user.
#### **goToReportPage(RemoteWebDriver $driver) : void**
- Navigates to the specified report page.
#### **loadReport(RemoteWebDriver $driver, string $startDate = null, string $endDate = null) : void**
- Inputs date ranges to filter the report.
- Defaults to the current day if dates are not provided.
#### **setNameAndLoad(RemoteWebDriver $driver, string $userName = '') : bool**
- Triggers the download of a report in the specified format (JSON or CSV).

## **Steps to deploy the repository and run the commands:**
1. **Clone the Repository (if not already done):** If you haven't cloned the repository yet, run the following command to clone it:

<pre> git clone <repository\_url> </pre>

2. **Navigate to the Project Directory:** Change to the directory where the repository is located (e.g., /IMS-scraping):

<pre >cd /project/path/ </pre>

3. **Install PHP Dependencies with Composer:** Run the composer install command in the project directory. This will install all PHP dependencies defined in the composer.json file.

<pre>composer install</pre>

4. **Download and Run Selenium Server:** Download the Selenium Server (if you don't have it already) and start it with the following command:

<pre >java -jar selenium-server.jar standalone</pre>

5. **Run the PHP Script:** If the script you're executing is script.php and it’s located in the /IMS-scraping folder, you can run the script using PHP like this:

<pre >php index.php</pre>

If there are dependencies or environment variables required by the script, ensure they are properly configured before running the script.

### **Additional Notes:**
- You will need to install Firefox/Firefox Web driver + LAMP + Composer
- Make sure you have **Java** installed on your machine, as this command runs the Selenium server using Java (run java -version from the command string).
- Make sure the selenium-server.jar file is located in a directory accessible from where you are running the java command. If it's in a different location, specify the full path to the JAR file.
- If your PHP script (index.php) interacts with Selenium (for example, using WebDriver for browser automation), ensure that the Selenium server is running before executing the PHP script.
- If the project requires a specific configuration or additional steps, check the repository documentation (e.g., README.md) for further instructions.
- Ask me for the valid .env file with all credentials
