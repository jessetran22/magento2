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
 * @Title("MC-37425: Verify the Currency Option tab expands automatically.")
 * @Description("Check auto open the collapse on Currency Option page.<h3>Test files</h3>app/code/Magento/CurrencySymbol/Test/Mftf/Test/AdminCurrencyOptionsSystemConfigExpandedTabTest.xml<br>")
 * @TestCaseId("MC-37425")
 */
class AdminCurrencyOptionsSystemConfigExpandedTabTestCest
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
	 * @Stories({"Expanded tab"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCurrencyOptionsSystemConfigExpandedTabTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToStoresCurrencyRatesPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToStoresCurrencyRatesPage
		$I->click("li[data-ui-id='menu-magento-backend-stores']"); // stepKey: clickOnMenuItemNavigateToStoresCurrencyRatesPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToStoresCurrencyRatesPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-currencysymbol-system-currency-rates']"); // stepKey: clickOnSubmenuItemNavigateToStoresCurrencyRatesPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToStoresCurrencyRatesPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToStoresCurrencyRatesPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [navigateToOptions] AdminNavigateToCurrencyRatesOptionActionGroup");
		$I->click("//button[@title='Options']"); // stepKey: clickOptionsButtonNavigateToOptions
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToOptions
		$I->comment("Exiting Action Group [navigateToOptions] AdminNavigateToCurrencyRatesOptionActionGroup");
		$grabClass = $I->grabAttributeFrom("#currency_options-head", "class"); // stepKey: grabClass
		$I->assertStringContainsString("open", $grabClass); // stepKey: assertClass
	}
}
