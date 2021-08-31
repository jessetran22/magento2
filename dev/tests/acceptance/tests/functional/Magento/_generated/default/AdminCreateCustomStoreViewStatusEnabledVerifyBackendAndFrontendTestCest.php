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
 * @Title("MC-14306: Create Custom Store View Status Enabled and Verify Backend and Frontend")
 * @Description("Test log in to Stores and Create Custom Store View Status Enabled and Verify Backend and Frontend Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateCustomStoreViewStatusEnabledVerifyBackendAndFrontendTest.xml<br>")
 * @TestCaseId("MC-14306")
 * @group store
 * @group mtf_migrated
 */
class AdminCreateCustomStoreViewStatusEnabledVerifyBackendAndFrontendTestCest
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
		$I->comment("Create store");
		$I->comment("Entering Action Group [createStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateStore
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: enterStoreGroupNameCreateStore
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: enterStoreGroupCodeCreateStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateStore
		$I->comment("Exiting Action Group [createStore] AdminCreateNewStoreGroupActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteStoreWaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteStore
		$I->comment("Exiting Action Group [deleteStore] DeleteCustomStoreActionGroup");
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
	public function AdminCreateCustomStoreViewStatusEnabledVerifyBackendAndFrontendTest(AcceptanceTester $I)
	{
		$I->comment("Create custom store view");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreCreateStoreView
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
		$I->comment("Search store view(from above step) in grid and verify AssertStoreInGrid");
		$I->comment("Entering Action Group [searchStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSearchStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSearchStoreViewInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSearchStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSearchStoreViewInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillSearchStoreViewFieldSearchStoreViewInGrid
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldSearchStoreViewInGridWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSearchStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchStoreViewInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchStoreViewInGrid
		$I->see("storeView" . msq("storeViewData"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreViewInGridMessageSearchStoreViewInGrid
		$I->comment("Exiting Action Group [searchStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->comment("Go to store view form page and verify AssertStoreForm");
		$I->comment("Entering Action Group [verifyStoreViewForm] AssertStoreViewFormActionGroup");
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewFirstRowInGridVerifyStoreViewForm
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStoreViewPageLoadVerifyStoreViewForm
		$I->seeInField("#store_group_id", "store" . msq("customStore")); // stepKey: seeAssertStoreVerifyStoreViewForm
		$I->seeInField("#store_name", "storeView" . msq("storeViewData")); // stepKey: seeAssertStoreViewNameVerifyStoreViewForm
		$I->seeInField("#store_code", "storeView" . msq("storeViewData")); // stepKey: seeAssertStoreViewCodeVerifyStoreViewForm
		$I->seeInField("#store_is_active", "Enabled"); // stepKey: seeAssertStatusVerifyStoreViewForm
		$I->comment("Exiting Action Group [verifyStoreViewForm] AssertStoreViewFormActionGroup");
		$I->comment("Go to store configuration page and verify AssertStoreBackend");
		$I->comment("Entering Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: goToConfigStoreConfigurationPageVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: waitForSystemStoreConfigurationPageLoadVerifyValuesOnStoreBackend
		$I->click("#store-change-button"); // stepKey: clickDefaultConfigButtonVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: clickDefaultConfigButtonVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("Main Website", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertWebsiteInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertWebsiteInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("store" . msq("customStore"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("storeView" . msq("storeViewData"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("", "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->comment("Exiting Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->comment("Go to storefront and verify AssertStoreFrontend");
		$I->comment("Entering Action Group [verifyValuesOnStoreFrontend] AssertStorefrontStoreVisibleInFooterActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontHomePageLoadVerifyValuesOnStoreFrontend
		$I->click("#switcher-store-trigger"); // stepKey: clickSwitchStoreButtonVerifyValuesOnStoreFrontend
		$I->waitForElementVisible("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStore") . "')]", 30); // stepKey: waitForStoreLinkToVosibleVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStoreLinkToVosibleVerifyValuesOnStoreFrontendWaitForPageLoad
		$I->seeElement("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStore") . "')]"); // stepKey: seeAssertStoreOnStorefrontVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: seeAssertStoreOnStorefrontVerifyValuesOnStoreFrontendWaitForPageLoad
		$I->comment("Exiting Action Group [verifyValuesOnStoreFrontend] AssertStorefrontStoreVisibleInFooterActionGroup");
	}
}
