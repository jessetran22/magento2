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
 * @Title("[NO TESTCASEID]: Currency symbols are disabled by default")
 * @Description("Currency symbols should be disabled by default<h3>Test files</h3>app/code/Magento/CurrencySymbol/Test/Mftf/Test/AdminDefaultCurrencySymbolsAreDisabledTest.xml<br>")
 * @group currency
 */
class AdminCurrencySymbolsAreDisabledTestCest
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
		$setAllowedCurrencyWebsites_EUR_RUB_USD = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD,EUR,RUB", 60); // stepKey: setAllowedCurrencyWebsites_EUR_RUB_USD
		$I->comment($setAllowedCurrencyWebsites_EUR_RUB_USD);
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
		$setAllowedCurrencyWebsites_EUR_USD = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD,EUR", 60); // stepKey: setAllowedCurrencyWebsites_EUR_USD
		$I->comment($setAllowedCurrencyWebsites_EUR_USD);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Currency Symbols"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCurrencySymbolsAreDisabledTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCurrencySymbolsPage] AdminNavigateToCurrencySymbolsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_currencysymbol/"); // stepKey: navigateToCurrencySymbolsPageNavigateToCurrencySymbolsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCurrencySymbolsPage
		$I->comment("Exiting Action Group [navigateToCurrencySymbolsPage] AdminNavigateToCurrencySymbolsPageActionGroup");
		$I->comment("Entering Action Group [assertEURDisabledInput] AssertAdminCurrencySymbolIsDisabledActionGroup");
		$grabDisabledAttributeAssertEURDisabledInput = $I->grabAttributeFrom("#currency-symbols-form #custom_currency_symbolEUR", "disabled"); // stepKey: grabDisabledAttributeAssertEURDisabledInput
		$I->assertEquals("true", $grabDisabledAttributeAssertEURDisabledInput); // stepKey: assertInputIsDisabledAssertEURDisabledInput
		$I->comment("Exiting Action Group [assertEURDisabledInput] AssertAdminCurrencySymbolIsDisabledActionGroup");
		$I->comment("Entering Action Group [assertUSDDisabledInput] AssertAdminCurrencySymbolIsDisabledActionGroup");
		$grabDisabledAttributeAssertUSDDisabledInput = $I->grabAttributeFrom("#currency-symbols-form #custom_currency_symbolUSD", "disabled"); // stepKey: grabDisabledAttributeAssertUSDDisabledInput
		$I->assertEquals("true", $grabDisabledAttributeAssertUSDDisabledInput); // stepKey: assertInputIsDisabledAssertUSDDisabledInput
		$I->comment("Exiting Action Group [assertUSDDisabledInput] AssertAdminCurrencySymbolIsDisabledActionGroup");
		$I->comment("Entering Action Group [assertRUBDisabledInput] AssertAdminCurrencySymbolIsDisabledActionGroup");
		$grabDisabledAttributeAssertRUBDisabledInput = $I->grabAttributeFrom("#currency-symbols-form #custom_currency_symbolRUB", "disabled"); // stepKey: grabDisabledAttributeAssertRUBDisabledInput
		$I->assertEquals("true", $grabDisabledAttributeAssertRUBDisabledInput); // stepKey: assertInputIsDisabledAssertRUBDisabledInput
		$I->comment("Exiting Action Group [assertRUBDisabledInput] AssertAdminCurrencySymbolIsDisabledActionGroup");
	}
}
