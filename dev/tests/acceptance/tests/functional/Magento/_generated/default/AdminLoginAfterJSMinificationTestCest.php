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
 * @Title("MC-14104: Admin panel should be accessible with JS minification enabled")
 * @Description("Admin panel should be accessible with JS minification enabled<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminLoginAfterJSMinificationTest.xml<br>")
 * @TestCaseId("MC-14104")
 * @group backend
 * @group mtf_migrated
 */
class AdminLoginAfterJSMinificationTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$enableJsMinification = $I->magentoCLI("config:set dev/js/minify_files 1", 60); // stepKey: enableJsMinification
		$I->comment($enableJsMinification);
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
		$deployStaticContent = $I->magentoCLI("setup:static-content:deploy -f", 60); // stepKey: deployStaticContent
		$I->comment($deployStaticContent);
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
		$disableJsMinification = $I->magentoCLI("config:set dev/js/minify_files 0", 60); // stepKey: disableJsMinification
		$I->comment($disableJsMinification);
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
	 * @Stories({"Admin Panel JS minification"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAfterJSMinificationTest(AcceptanceTester $I)
	{
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOnDashboard
		$I->see("Dashboard", ".page-header h1.page-title"); // stepKey: seeDashboardTitle
		$I->comment("Entering Action Group [loggedInSuccessfully] AssertAdminSuccessLoginActionGroup");
		$I->waitForElementVisible(".page-header .admin-user-account-text", 30); // stepKey: waitForAdminAccountTextVisibleLoggedInSuccessfully
		$I->seeElement(".page-header .admin-user-account-text"); // stepKey: assertAdminAccountTextElementLoggedInSuccessfully
		$I->comment("Exiting Action Group [loggedInSuccessfully] AssertAdminSuccessLoginActionGroup");
		$I->comment("Entering Action Group [dontSee404Page] AssertAdminPageIsNot404ActionGroup");
		$I->dontSee("404 Error", ".page-content .page-heading"); // stepKey: dontSee404PageHeadingDontSee404Page
		$I->comment("Exiting Action Group [dontSee404Page] AssertAdminPageIsNot404ActionGroup");
	}
}
