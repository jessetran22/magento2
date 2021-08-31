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
 * @Title("MC-14118: Admin stores all stores navigate menu test")
 * @Description("Admin should be able to navigate to Stores > All Stores<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminStoresAllStoresNavigateMenuTest.xml<br>")
 * @TestCaseId("MC-14118")
 * @group menu
 * @group mtf_migrated
 */
class AdminStoresAllStoresNavigateMenuTestCest
{
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
	 * @Features({"Backend"})
	 * @Stories({"Menu Navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminStoresAllStoresNavigateMenuTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToStoresAllStoresPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToStoresAllStoresPage
		$I->click("li[data-ui-id='menu-magento-backend-stores']"); // stepKey: clickOnMenuItemNavigateToStoresAllStoresPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToStoresAllStoresPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-backend-system-store']"); // stepKey: clickOnSubmenuItemNavigateToStoresAllStoresPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToStoresAllStoresPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToStoresAllStoresPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [seePageTitle] AdminAssertPageTitleActionGroup");
		$I->see("Stores", ".page-title-wrapper h1"); // stepKey: assertPageTitleSeePageTitle
		$I->comment("Exiting Action Group [seePageTitle] AdminAssertPageTitleActionGroup");
	}
}
