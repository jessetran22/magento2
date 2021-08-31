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
 * @Title("https://github.com/magento/magento2/pull/25926: Admin content themes sort themes test")
 * @Description("Admin should be able to sort Themes<h3>Test files</h3>app/code/Magento/Theme/Test/Mftf/Test/AdminContentThemeSortTest.xml<br>")
 * @TestCaseId("https://github.com/magento/magento2/pull/25926")
 * @group menu
 */
class AdminContentThemesSortTestCest
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
	 * @Features({"Theme"})
	 * @Stories({"Menu Navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminContentThemesSortTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToContentThemesPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToContentThemesPage
		$I->click("li[data-ui-id='menu-magento-backend-content']"); // stepKey: clickOnMenuItemNavigateToContentThemesPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToContentThemesPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-theme-system-design-theme']"); // stepKey: clickOnSubmenuItemNavigateToContentThemesPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToContentThemesPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToContentThemesPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [seePageTitle] AdminAssertPageTitleActionGroup");
		$I->see("Themes", ".page-title-wrapper h1"); // stepKey: assertPageTitleSeePageTitle
		$I->comment("Exiting Action Group [seePageTitle] AdminAssertPageTitleActionGroup");
		$I->click("//thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Theme Title']"); // stepKey: clickSortByTitle
		$I->waitForPageLoad(30); // stepKey: clickSortByTitleWaitForPageLoad
		$I->click("//thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Theme Title']"); // stepKey: clickSortByTitleSecondTime
		$I->waitForPageLoad(30); // stepKey: clickSortByTitleSecondTimeWaitForPageLoad
		$I->seeNumberOfElements("//tbody/tr/td[contains(@class, 'theme_path')]", "2"); // stepKey: see2RowsOnTheGrid
		$I->seeNumberOfElements("//tbody//tr//div[contains(text(), 'Magento Luma')]", "1"); // stepKey: seeLumaThemeInTitleColumn
	}
}
