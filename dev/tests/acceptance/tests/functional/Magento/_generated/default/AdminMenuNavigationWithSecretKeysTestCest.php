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
 * @Title("MAGETWO-95349: Admin should be able to navigate between menu options with secret url keys enabled")
 * @Description("Admin should be able to navigate between menu options with secret url keys enabled<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminMenuNavigationWithSecretKeysTest.xml<br>")
 * @TestCaseId("MAGETWO-95349")
 * @group menu
 */
class AdminMenuNavigationWithSecretKeysTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$enableUrlSecretKeys = $I->magentoCLI("config:set admin/security/use_form_key 1", 60); // stepKey: enableUrlSecretKeys
		$I->comment($enableUrlSecretKeys);
		$I->comment("Entering Action Group [cleanInvalidatedCaches1] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches1 = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches1
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches1);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches1] CliCacheCleanActionGroup");
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
		$disableUrlSecretKeys = $I->magentoCLI("config:set admin/security/use_form_key 0", 60); // stepKey: disableUrlSecretKeys
		$I->comment($disableUrlSecretKeys);
		$I->comment("Entering Action Group [cleanInvalidatedCaches2] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches2 = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches2
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches2);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches2] CliCacheCleanActionGroup");
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
	public function AdminMenuNavigationWithSecretKeysTest(AcceptanceTester $I)
	{
		$I->click("#menu-magento-backend-stores"); // stepKey: clickStoresMenuOption1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForStoresMenu1
		$I->waitForElementVisible("#nav li[data-ui-id='menu-magento-config-system-config']", 30); // stepKey: waitForConfigurationVisible1
		$I->click("#nav li[data-ui-id='menu-magento-config-system-config']"); // stepKey: clickStoresConfigurationMenuOption1
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationPageLoad1
		$I->seeCurrentUrlMatches("~\/admin\/system_config\/~"); // stepKey: seeCurrentUrlMatchesConfigPath1
		$I->click("#menu-magento-catalog-catalog"); // stepKey: clickCatalogMenuOption
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCatalogMenu1
		$I->waitForElementVisible("#nav li[data-ui-id='menu-magento-catalog-catalog-products']", 30); // stepKey: waitForCatalogProductsVisible
		$I->click("#nav li[data-ui-id='menu-magento-catalog-catalog-products']"); // stepKey: clickCatalogProductsMenuOption
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageLoad
		$I->seeCurrentUrlMatches("~\/catalog\/product\/~"); // stepKey: seeCurrentUrlMatchesProductsPath
		$I->click("#menu-magento-backend-stores"); // stepKey: clickStoresMenuOption2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForStoresMenu2
		$I->waitForElementVisible("#nav li[data-ui-id='menu-magento-config-system-config']", 30); // stepKey: waitForConfigurationVisible2
		$I->click("#nav li[data-ui-id='menu-magento-config-system-config']"); // stepKey: clickStoresConfigurationMenuOption2
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationPageLoad2
		$I->seeCurrentUrlMatches("~\/admin\/system_config\/~"); // stepKey: seeCurrentUrlMatchesConfigPath2
	}
}
