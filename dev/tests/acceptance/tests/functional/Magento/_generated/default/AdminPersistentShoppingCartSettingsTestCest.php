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
 * @Title("[NO TESTCASEID]: Admin should be able to manage persistent shopping cart settings")
 * @Description("Admin should be able to enable persistent shopping cart in Magento Admin backend and see additional options<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminPersistentShoppingCartSettingsTest.xml<br>")
 * @group backend
 */
class AdminPersistentShoppingCartSettingsTestCest
{
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
		$enablePersistentShoppingCart = $I->magentoCLI("config:set persistent/options/enabled 1", 60); // stepKey: enablePersistentShoppingCart
		$I->comment($enablePersistentShoppingCart);
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disablePersistentShoppingCart = $I->magentoCLI("config:set persistent/options/enabled 0", 60); // stepKey: disablePersistentShoppingCart
		$I->comment($disablePersistentShoppingCart);
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
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
	 * @Stories({"Enable Persistent Shopping cart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminPersistentShoppingCartSettingsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToPersistenceSettings] AdminNavigateToPersistentShoppingCartSettingsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/persistent/"); // stepKey: navigateToPersistencePageNavigateToPersistenceSettings
		$I->conditionalClick(".entry-edit-head-link", ".entry-edit-head-link:not(.open)", true); // stepKey: clickTabNavigateToPersistenceSettings
		$I->comment("Exiting Action Group [navigateToPersistenceSettings] AdminNavigateToPersistentShoppingCartSettingsActionGroup");
		$I->comment("Entering Action Group [assertOptions] AssertAdminPersistentShoppingCartOptionsAvailableActionGroup");
		$I->seeElement("#persistent_options_lifetime"); // stepKey: seeLifetimeInputAssertOptions
		$I->seeElement("#persistent_options_remember_enabled"); // stepKey: seeRememberMeEnableInputAssertOptions
		$I->seeElement("#persistent_options_remember_default"); // stepKey: seeRememberMeDefaultInputAssertOptions
		$I->seeElement("#persistent_options_logout_clear"); // stepKey: seeClearPersistenceAssertOptions
		$I->seeElement("#persistent_options_shopping_cart"); // stepKey: seePersistShoppingCartAssertOptions
		$I->comment("Exiting Action Group [assertOptions] AssertAdminPersistentShoppingCartOptionsAvailableActionGroup");
	}
}
