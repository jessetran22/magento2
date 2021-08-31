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
 * @Title("MC-39443: Mini search field appears if suggestions was disabled")
 * @Description("Mini search field appears if suggestions was disabled<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/StorefrontVerifySearchFieldVisibilityWhenSuggestionDisabledTest.xml<br>")
 * @TestCaseId("MC-39443")
 * @group mtf_migrated
 */
class StorefrontVerifySearchFieldVisibilityWhenSuggestionDisabledTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Disable search suggestion");
		$disableSearchSuggestion = $I->magentoCLI("config:set catalog/search/search_suggestion_enabled 0", 60); // stepKey: disableSearchSuggestion
		$I->comment($disableSearchSuggestion);
		$I->comment("Entering Action Group [cleanCacheFirst] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCacheFirst = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanCacheFirst
		$I->comment($cleanSpecifiedCacheCleanCacheFirst);
		$I->comment("Exiting Action Group [cleanCacheFirst] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Enable search suggestion back");
		$disableSearchSuggestion = $I->magentoCLI("config:set catalog/search/search_suggestion_enabled 1", 60); // stepKey: disableSearchSuggestion
		$I->comment($disableSearchSuggestion);
		$I->comment("Entering Action Group [cleanCacheSecond] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCacheSecond = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanCacheSecond
		$I->comment($cleanSpecifiedCacheCleanCacheSecond);
		$I->comment("Exiting Action Group [cleanCacheSecond] CliCacheCleanActionGroup");
		$I->comment("Admin logout");
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
	 * @Stories({"Search Term"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Search"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySearchFieldVisibilityWhenSuggestionDisabledTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront home page");
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->resizeWindow(767, 720); // stepKey: resizeWindowToMobileView
		$I->click("//*[@id='search_mini_form']//label[@data-role='minisearch-label']"); // stepKey: clickOnMagnifierSearchIcon
		$I->waitForElementVisible("#search", 30); // stepKey: seeInputSearchActive
	}
}
