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
 * @Title("MC-14152: Admin advanced reporting navigate menu test")
 * @Description("Admin should be able to navigate through advanced reporting admin menu to BI reports page<h3>Test files</h3>app/code/Magento/Analytics/Test/Mftf/Test/AdminAdvancedReportingNavigateMenuTest.xml<br>")
 * @TestCaseId("MC-14152")
 * @group menu
 * @group mtf_migrated
 */
class AdminAdvancedReportingNavigateMenuTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
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
	 * @Features({"Analytics"})
	 * @Stories({"Menu Navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAdvancedReportingNavigateMenuTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateAdvancedReportingPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateAdvancedReportingPage
		$I->click("li[data-ui-id='menu-magento-reports-report']"); // stepKey: clickOnMenuItemNavigateAdvancedReportingPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateAdvancedReportingPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-analytics-advanced-reporting']"); // stepKey: clickOnSubmenuItemNavigateAdvancedReportingPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateAdvancedReportingPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateAdvancedReportingPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [assertAdvancedReportingPageUrl] AssertAdminAdvancedReportingPageUrlActionGroup");
		$I->switchToNextTab(); // stepKey: switchToNewTabAssertAdvancedReportingPageUrl
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedReportingPageLoadAssertAdvancedReportingPageUrl
		$I->seeInCurrentUrl("reports/advanced-reporting"); // stepKey: seeAssertAdvancedReportingPageUrlAssertAdvancedReportingPageUrl
		$I->comment("Exiting Action Group [assertAdvancedReportingPageUrl] AssertAdminAdvancedReportingPageUrlActionGroup");
	}
}
