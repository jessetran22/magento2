<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-28786: Currency Converter API configuration")
 * @Description("Admin should be able to import currency rates using Currency Converter API<h3>Test files</h3>app/code/Magento/CurrencySymbol/Test/Mftf/Test/AdminCheckCurrencyConverterApiConfigurationTest.xml<br>")
 * @TestCaseId("MC-28786")
 * @group currency
 */
class AdminCheckCurrencyConverterApiConfigurationTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Set currency configuration");
		$setAllowedCurrencyRHDAndUSD = $I->magentoCLI("config:set currency/options/allow USD,RHD", 60); // stepKey: setAllowedCurrencyRHDAndUSD
		$I->comment($setAllowedCurrencyRHDAndUSD);
		$setCurrencyConverterApiKey = $I->magentoCLISecret("config:set currency/currencyconverterapi/api_key " . $I->getSecret("magento/currency_currencyconverterapi_api_key"), 60); // stepKey: setCurrencyConverterApiKey
		$I->comment($setCurrencyConverterApiKey); // stepKey: setCurrencyConverterApiKey
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set currency allow previous config");
		$setDefaultAllowedCurrencies = $I->magentoCLI("config:set currency/options/allow USD", 60); // stepKey: setDefaultAllowedCurrencies
		$I->comment($setDefaultAllowedCurrencies);
		$setDefaultCurrencyConverterApiKey = $I->magentoCLI("config:set currency/currencyconverterapi/api_key ''", 60); // stepKey: setDefaultCurrencyConverterApiKey
		$I->comment($setDefaultCurrencyConverterApiKey);
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"CurrencySymbol"})
	 * @Stories({"Currency Rates"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckCurrencyConverterApiConfigurationTest(AcceptanceTester $I)
	{
		$I->comment("Import rates from Currency Converter API");
		$I->comment("Entering Action Group [openCurrencyRatesPage] AdminOpenCurrencyRatesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_currency/"); // stepKey: openCurrencyRatesPageOpenCurrencyRatesPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCurrencyRatesPage
		$I->comment("Exiting Action Group [openCurrencyRatesPage] AdminOpenCurrencyRatesPageActionGroup");
		$I->comment("Entering Action Group [importCurrencyRates] AdminImportUnsupportedCurrencyRatesActionGroup");
		$I->selectOption("#rate_services", "Currency Converter API"); // stepKey: selectRateServiceImportCurrencyRates
		$I->click("//button[@title='Import']"); // stepKey: clickImportImportCurrencyRates
		$I->waitForElementVisible("//div[contains(@class, 'admin__field-note') and contains(text(), 'Old rate:')]", 30); // stepKey: waitForOldRateVisibleImportCurrencyRates
		$I->comment("Exiting Action Group [importCurrencyRates] AdminImportUnsupportedCurrencyRatesActionGroup");
		$I->comment("Entering Action Group [seeWarningMessageForRHD] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-warning", 30); // stepKey: waitForMessageVisibleSeeWarningMessageForRHD
		$I->see("We can't retrieve a rate from https://free.currconv.com for RHD.", "#messages div.message-warning"); // stepKey: verifyMessageSeeWarningMessageForRHD
		$I->comment("Exiting Action Group [seeWarningMessageForRHD] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [seeWarningMessageSaved] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-warning", 30); // stepKey: waitForMessageVisibleSeeWarningMessageSaved
		$I->see("Click \"Save\" to apply the rates we found.", "#messages div.message-warning"); // stepKey: verifyMessageSeeWarningMessageSaved
		$I->comment("Exiting Action Group [seeWarningMessageSaved] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [saveCurrencyRates] AdminSaveCurrencyRatesActionGroup");
		$I->click("//button[@title='Save Currency Rates']"); // stepKey: clickSaveCurrencyRatesSaveCurrencyRates
		$I->waitForPageLoad(30); // stepKey: waitForSaveSaveCurrencyRates
		$I->see("All valid rates have been saved.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveCurrencyRates
		$I->comment("Exiting Action Group [saveCurrencyRates] AdminSaveCurrencyRatesActionGroup");
		$I->comment("Entering Action Group [seeRHDMessageAfterSave] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeRHDMessageAfterSave
		$I->see("All valid rates have been saved.", "#messages div.message-success"); // stepKey: verifyMessageSeeRHDMessageAfterSave
		$I->comment("Exiting Action Group [seeRHDMessageAfterSave] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [seeValidRatesSaved] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-warning", 30); // stepKey: waitForMessageVisibleSeeValidRatesSaved
		$I->see("Please correct the input data for \"USD => RHD\" rate", "#messages div.message-warning"); // stepKey: verifyMessageSeeValidRatesSaved
		$I->comment("Exiting Action Group [seeValidRatesSaved] AssertMessageInAdminPanelActionGroup");
		$setAllowedCurrencyEURAndUSD = $I->magentoCLI("config:set currency/options/allow USD,EUR", 60); // stepKey: setAllowedCurrencyEURAndUSD
		$I->comment($setAllowedCurrencyEURAndUSD);
		$I->comment("Entering Action Group [openCurrencyRatesPageAfterSetEUR] AdminOpenCurrencyRatesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_currency/"); // stepKey: openCurrencyRatesPageOpenCurrencyRatesPageAfterSetEUR
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCurrencyRatesPageAfterSetEUR
		$I->comment("Exiting Action Group [openCurrencyRatesPageAfterSetEUR] AdminOpenCurrencyRatesPageActionGroup");
		$I->comment("Entering Action Group [importCurrencyRatesAfterEUR] AdminImportCurrencyRatesActionGroup");
		$I->selectOption("#rate_services", "Currency Converter API"); // stepKey: selectRateServiceImportCurrencyRatesAfterEUR
		$I->click("//button[@title='Import']"); // stepKey: clickImportImportCurrencyRatesAfterEUR
		$I->waitForElementVisible("//div[contains(@class, 'admin__field-note') and contains(text(), 'Old rate:')]/strong", 30); // stepKey: waitForOldRateVisibleImportCurrencyRatesAfterEUR
		$I->comment("Exiting Action Group [importCurrencyRatesAfterEUR] AdminImportCurrencyRatesActionGroup");
		$I->dontSee("We can't retrieve a rate from https://free.currconv.com for EUR.", "#messages div.message-warning"); // stepKey: dontSeeWarningMessageForEUR
		$I->comment("Entering Action Group [seeSuccessMessageForSaveRates] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeSuccessMessageForSaveRates
		$I->see("Click \"Save\" to apply the rates we found.", "#messages div.message-success"); // stepKey: verifyMessageSeeSuccessMessageForSaveRates
		$I->comment("Exiting Action Group [seeSuccessMessageForSaveRates] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [saveCurrencyRatesAfterEUR] AdminSaveCurrencyRatesActionGroup");
		$I->click("//button[@title='Save Currency Rates']"); // stepKey: clickSaveCurrencyRatesSaveCurrencyRatesAfterEUR
		$I->waitForPageLoad(30); // stepKey: waitForSaveSaveCurrencyRatesAfterEUR
		$I->see("All valid rates have been saved.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveCurrencyRatesAfterEUR
		$I->comment("Exiting Action Group [saveCurrencyRatesAfterEUR] AdminSaveCurrencyRatesActionGroup");
		$I->dontSee("Please correct the input data for \"USD => EUR\" rate", "#messages div.message-warning"); // stepKey: dontSeeWarningMessageCorrectForEUR
		$I->comment("Entering Action Group [seeValidRatesEURSaved] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeValidRatesEURSaved
		$I->see("All valid rates have been saved.", "#messages div.message-success"); // stepKey: verifyMessageSeeValidRatesEURSaved
		$I->comment("Exiting Action Group [seeValidRatesEURSaved] AssertMessageInAdminPanelActionGroup");
		$I->comment("Go to the Storefront and check currency rates");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCreatedProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [switchToEURCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->click("#switcher-currency-trigger"); // stepKey: openToggleSwitchToEURCurrency
		$I->waitForPageLoad(30); // stepKey: openToggleSwitchToEURCurrencyWaitForPageLoad
		$I->waitForElementVisible("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'EUR')]", 30); // stepKey: waitForCurrencySwitchToEURCurrency
		$I->waitForPageLoad(10); // stepKey: waitForCurrencySwitchToEURCurrencyWaitForPageLoad
		$I->click("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'EUR')]"); // stepKey: chooseCurrencySwitchToEURCurrency
		$I->waitForPageLoad(10); // stepKey: chooseCurrencySwitchToEURCurrencyWaitForPageLoad
		$I->see("EUR", "#switcher-currency-trigger span"); // stepKey: seeSelectedCurrencySwitchToEURCurrency
		$I->comment("Exiting Action Group [switchToEURCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->see("€", ".price-final_price"); // stepKey: seeEURCurrencySymbolInPrice
		$I->comment("Set allowed currencies greater then 10");
		$setGreaterThanTenAllowedCurrencies = $I->magentoCLI("config:set currency/options/allow RHD,CHW,YER,ZMK,CHE,EUR,USD,AMD,RUB,DZD,ARS,AWG", 60); // stepKey: setGreaterThanTenAllowedCurrencies
		$I->comment($setGreaterThanTenAllowedCurrencies);
		$I->comment("Import rates from Currency Converter API with currencies greater then 10");
		$I->comment("Entering Action Group [openCurrencyRatesPageAfterChangeAllowed] AdminOpenCurrencyRatesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_currency/"); // stepKey: openCurrencyRatesPageOpenCurrencyRatesPageAfterChangeAllowed
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCurrencyRatesPageAfterChangeAllowed
		$I->comment("Exiting Action Group [openCurrencyRatesPageAfterChangeAllowed] AdminOpenCurrencyRatesPageActionGroup");
		$I->comment("Entering Action Group [importCurrencyRatesGreaterThen10] AdminImportUnsupportedCurrencyRatesActionGroup");
		$I->selectOption("#rate_services", "Currency Converter API"); // stepKey: selectRateServiceImportCurrencyRatesGreaterThen10
		$I->click("//button[@title='Import']"); // stepKey: clickImportImportCurrencyRatesGreaterThen10
		$I->waitForElementVisible("//div[contains(@class, 'admin__field-note') and contains(text(), 'Old rate:')]", 30); // stepKey: waitForOldRateVisibleImportCurrencyRatesGreaterThen10
		$I->comment("Exiting Action Group [importCurrencyRatesGreaterThen10] AdminImportUnsupportedCurrencyRatesActionGroup");
		$I->comment("Entering Action Group [seeTooManyPairsMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-warning", 30); // stepKey: waitForMessageVisibleSeeTooManyPairsMessage
		$I->see("Too many pairs. Maximum of 2 is supported for this free version.", "#messages div.message-warning"); // stepKey: verifyMessageSeeTooManyPairsMessage
		$I->comment("Exiting Action Group [seeTooManyPairsMessage] AssertMessageInAdminPanelActionGroup");
	}
}
