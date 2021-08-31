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
 * @Title("MC-36869: AdminAnalytics Check Tracking.")
 * @Description("AdminAnalytics Check Tracking.<h3>Test files</h3>app/code/Magento/AdminAnalytics/Test/Mftf/Test/AdminCheckAnalyticsTrackingTest.xml<br>")
 * @TestCaseId("MC-36869")
 */
class AdminCheckAnalyticsTrackingTestCest
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
		$enableAdminUsageTracking = $I->magentoCLI("config:set admin/usage/enabled 1", 60); // stepKey: enableAdminUsageTracking
		$I->comment($enableAdminUsageTracking);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$I->reloadPage(); // stepKey: pageReload
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disableAdminUsageTracking = $I->magentoCLI("config:set admin/usage/enabled 0", 60); // stepKey: disableAdminUsageTracking
		$I->comment($disableAdminUsageTracking);
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
	 * @Stories({"AdminAnalytics Check Tracking."})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Features({"AdminAnalytics"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckAnalyticsTrackingTest(AcceptanceTester $I)
	{
		$I->waitForPageLoad(30); // stepKey: waitForPageReloaded
		$I->seeInPageSource("var adminAnalyticsMetadata ="); // stepKey: seeInPageSource
		$pageSource = $I->grabPageSource(); // stepKey: pageSource
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?(\"[\w_]+\":\s+\"[^\"]*?\"\s+)};#s", $pageSource, "adminAnalyticsMetadata object is invalid"); // stepKey: validateadminAnalyticsMetadata
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"user\":\s+\"[\w\d]{64}\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect user ID"); // stepKey: validateUserId
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"secure_base_url\":\s+\"http(s)?\\\\u003A\\\\u002F\\\\u002F.+?\\\\u002F\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect secure base URL"); // stepKey: validateSecureBaseURL
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"version\":\s+\"[^\s]+\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect product version"); // stepKey: validateProductVersion
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"product_edition\":\s+\"(Community|Enterprise|B2B)\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect product edition"); // stepKey: validateProductEdition
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"mode\":\s+\"default|developer|production\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect application mode"); // stepKey: validateApplicationMode
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"store_name_default\":\s+\".*?\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect store name"); // stepKey: validateStoreName
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"admin_user_created\":\s+\".+?\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect admin user created date"); // stepKey: validateAdminUserCreatedDate
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"admin_user_logdate\":\s+\".+?\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect admin user log date"); // stepKey: validateAdminUserLogDate
		$I->assertRegExp("#var\s+adminAnalyticsMetadata\s+=\s+{\s+(\"[\w_]+\":\s+\"[^\"]*?\",\s+)*?\"admin_user_role_name\":\s+\".+?\"#s", $pageSource, "adminAnalyticsMetadata object contains incorrect admin user role name"); // stepKey: validateAdminUserRoleName
	}
}
