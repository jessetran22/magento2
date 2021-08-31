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
 * @Title("MC-14304: Create Store View Status Enabled and Verify Backend and Frontend")
 * @Description("Test log in to Stores and Create Store View Status Enabled Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateStoreViewStatusEnabledVerifyBackendAndFrontendTest.xml<br>")
 * @TestCaseId("MC-14304")
 * @group store
 * @group mtf_migrated
 */
class AdminCreateStoreViewStatusEnabledVerifyBackendAndFrontendTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Create Store View"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateStoreViewStatusEnabledVerifyBackendAndFrontendTest(AcceptanceTester $I)
	{
		$I->comment("Create store view");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Save the above store view and verify AssertStoreViewSuccessSaveMessage");
		$I->comment("Entering Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadVerifyAssertStoreViewSuccessSaveMessage
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReload2VerifyAssertStoreViewSuccessSaveMessage
		$I->see("You saved the store view."); // stepKey: seeSavedMessageVerifyAssertStoreViewSuccessSaveMessage
		$I->comment("Exiting Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->comment("Go to store configuration page and verify AssertStoreBackend");
		$I->comment("Entering Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: goToConfigStoreConfigurationPageVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: waitForSystemStoreConfigurationPageLoadVerifyValuesOnStoreBackend
		$I->click("#store-change-button"); // stepKey: clickDefaultConfigButtonVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: clickDefaultConfigButtonVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertWebsiteInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertWebsiteInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("storeView" . msq("storeViewData"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->comment("Exiting Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->comment("Go to storefront and verify AssertStoreFrontend");
		$I->comment("Entering Action Group [verifyValuesOnStoreFrontend] AssertStorefrontStoreVisibleInHeaderActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontHomePageLoadVerifyValuesOnStoreFrontend
		$I->click("#switcher-language-trigger"); // stepKey: selectStoreSwitcherVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: waitForFirstStoreViewVerifyValuesOnStoreFrontend
		$I->see("storeView" . msq("storeViewData"), ".active ul.switcher-dropdown"); // stepKey: seeAssertStoreViewOnStorefrontVerifyValuesOnStoreFrontend
		$I->comment("Exiting Action Group [verifyValuesOnStoreFrontend] AssertStorefrontStoreVisibleInHeaderActionGroup");
	}
}
