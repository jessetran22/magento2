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
 * @Title("MC-14294: Move Store To Other Group Same Website and Verify Backend and Frontend")
 * @Description("Test log in to Stores and Move Store To Other Group Same Website Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminMoveStoreToOtherGroupSameWebsiteTest.xml<br>")
 * @TestCaseId("MC-14294")
 * @group store
 * @group mtf_migrated
 */
class AdminMoveStoreToOtherGroupSameWebsiteTestCest
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
		$I->comment("Create first store");
		$I->comment("Entering Action Group [createFirstStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateFirstStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateFirstStore
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: enterStoreGroupNameCreateFirstStore
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: enterStoreGroupCodeCreateFirstStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateFirstStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateFirstStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateFirstStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateFirstStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateFirstStore
		$I->comment("Exiting Action Group [createFirstStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create first store view");
		$I->comment("Entering Action Group [createFirstStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreCreateFirstStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData1")); // stepKey: enterStoreViewNameCreateFirstStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData1")); // stepKey: enterStoreViewCodeCreateFirstStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateFirstStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateFirstStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateFirstStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateFirstStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateFirstStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateFirstStoreView
		$I->comment("Exiting Action Group [createFirstStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Create second store");
		$I->comment("Entering Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateSecondStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateSecondStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateSecondStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStore
		$I->comment("Exiting Action Group [createSecondStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create second store view");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData2")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData2")); // stepKey: enterStoreViewCodeCreateSecondStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateSecondStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateSecondStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateSecondStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateSecondStoreView
		$I->comment("Exiting Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteFirstStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteFirstStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteFirstStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteFirstStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteFirstStoreWaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteFirstStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteFirstStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteFirstStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteFirstStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteFirstStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteFirstStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteFirstStore
		$I->comment("Exiting Action Group [deleteFirstStore] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [deleteSecondStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteSecondStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldDeleteSecondStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSecondStoreWaitForPageLoad
		$I->see("store" . msq("customStoreGroup"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteSecondStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteSecondStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteSecondStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteSecondStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteSecondStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteSecondStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteSecondStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondStore
		$I->comment("Exiting Action Group [deleteSecondStore] DeleteCustomStoreActionGroup");
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
	 * @Stories({"Move Store"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMoveStoreToOtherGroupSameWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Search created second store view in grid");
		$I->comment("Entering Action Group [searchCreatedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSearchCreatedStoreViewInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSearchCreatedStoreViewInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData2")); // stepKey: fillSearchStoreViewFieldSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldSearchCreatedStoreViewInGridWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchCreatedStoreViewInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchCreatedStoreViewInGrid
		$I->see("storeView" . msq("storeViewData2"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreViewInGridMessageSearchCreatedStoreViewInGrid
		$I->comment("Exiting Action Group [searchCreatedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->comment("Move created store view to other store keeping website same");
		$I->comment("Entering Action Group [moveStoreView] ChangeStoreInStoreViewActionGroup");
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewFirstRowInGridMoveStoreView
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStoreViewPageLoadMoveStoreView
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreGrpDropdownMoveStoreView
		$I->click("#save"); // stepKey: clickSaveButtonMoveStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveButtonMoveStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalMoveStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalMoveStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteMoveStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalMoveStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalMoveStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [moveStoreView] ChangeStoreInStoreViewActionGroup");
		$I->comment("Save the above store view and verify AssertStoreViewSuccessSaveMessage");
		$I->comment("Entering Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadVerifyAssertStoreViewSuccessSaveMessage
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReload2VerifyAssertStoreViewSuccessSaveMessage
		$I->see("You saved the store view."); // stepKey: seeSavedMessageVerifyAssertStoreViewSuccessSaveMessage
		$I->comment("Exiting Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->comment("Search moved store view(from above step) in grid and verify AssertStoreInGrid");
		$I->comment("Entering Action Group [searchMovedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSearchMovedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSearchMovedStoreViewInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSearchMovedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSearchMovedStoreViewInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData2")); // stepKey: fillSearchStoreViewFieldSearchMovedStoreViewInGrid
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldSearchMovedStoreViewInGridWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSearchMovedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchMovedStoreViewInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchMovedStoreViewInGrid
		$I->see("storeView" . msq("storeViewData2"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreViewInGridMessageSearchMovedStoreViewInGrid
		$I->comment("Exiting Action Group [searchMovedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->comment("Go to store view form page and verify AssertStoreForm");
		$I->comment("Entering Action Group [verifyStoreViewForm] AssertStoreViewFormActionGroup");
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewFirstRowInGridVerifyStoreViewForm
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStoreViewPageLoadVerifyStoreViewForm
		$I->seeInField("#store_group_id", "store" . msq("customStore")); // stepKey: seeAssertStoreVerifyStoreViewForm
		$I->seeInField("#store_name", "storeView" . msq("storeViewData2")); // stepKey: seeAssertStoreViewNameVerifyStoreViewForm
		$I->seeInField("#store_code", "storeView" . msq("storeViewData2")); // stepKey: seeAssertStoreViewCodeVerifyStoreViewForm
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
		$I->see("storeView" . msq("storeViewData1"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertFirstStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->see("storeView" . msq("storeViewData2"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackend
		$I->waitForPageLoad(30); // stepKey: seeAssertSecondStoreViewInDefaultConfigDropdownVerifyValuesOnStoreBackendWaitForPageLoad
		$I->comment("Exiting Action Group [verifyValuesOnStoreBackend] AssertStoreConfigurationBackendActionGroup");
		$I->comment("Go to storefront and verify AssertStoreFrontend");
		$I->comment("Entering Action Group [verifyValuesOnStoreFrontend] AssertStoreFrontendActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontHomePageLoadVerifyValuesOnStoreFrontend
		$I->click("#switcher-store-trigger"); // stepKey: clickSwitchStoreButtonVerifyValuesOnStoreFrontend
		$I->waitForElementVisible("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStore") . "')]", 30); // stepKey: waitForStoreLinkToVosibleVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStoreLinkToVosibleVerifyValuesOnStoreFrontendWaitForPageLoad
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStore") . "')]"); // stepKey: clickStoreLinkCustomStoreVerifyValuesOnStoreFrontend
		$I->waitForPageLoad(30); // stepKey: clickStoreLinkCustomStoreVerifyValuesOnStoreFrontendWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomStoreToLoadVerifyValuesOnStoreFrontend
		$I->see("storeView" . msq("storeViewData1"), "//*[@id='switcher-language-trigger']//span"); // stepKey: seeAssertFirstStoreViewOnStorefrontVerifyValuesOnStoreFrontend
		$I->click("//*[@id='switcher-language-trigger']//span"); // stepKey: clickStoreViewNameVerifyValuesOnStoreFrontend
		$I->see("storeView" . msq("storeViewData2"), ".active ul.switcher-dropdown"); // stepKey: seeAssertSecondStoreViewOnStorefrontVerifyValuesOnStoreFrontend
		$I->comment("Exiting Action Group [verifyValuesOnStoreFrontend] AssertStoreFrontendActionGroup");
	}
}
