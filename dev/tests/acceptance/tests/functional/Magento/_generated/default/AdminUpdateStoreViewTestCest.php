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
 * @Title("MC-14316: Update Store View and Verify Backend and Frontend")
 * @Description("Test log in to Stores and Update Store View Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminUpdateStoreViewTest.xml<br>")
 * @TestCaseId("MC-14316")
 * @group store
 * @group mtf_migrated
 */
class AdminUpdateStoreViewTestCest
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
		$I->comment("Create custom store view");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateNewStoreView
		$I->comment("Exiting Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
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
		$I->comment("Entering Action Group [deleteUpdatedStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteUpdatedStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteUpdatedStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteUpdatedStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteUpdatedStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "Second Store View " . msq("SecondStoreUnique")); // stepKey: fillStoreViewFilterFieldDeleteUpdatedStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteUpdatedStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteUpdatedStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteUpdatedStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteUpdatedStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteUpdatedStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteUpdatedStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteUpdatedStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteUpdatedStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteUpdatedStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteUpdatedStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteUpdatedStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteUpdatedStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteUpdatedStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteUpdatedStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteUpdatedStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteUpdatedStoreView
		$I->comment("Exiting Action Group [deleteUpdatedStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Update Store View"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("Search created store view in grid");
		$I->comment("Entering Action Group [searchCreatedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSearchCreatedStoreViewInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSearchCreatedStoreViewInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillSearchStoreViewFieldSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldSearchCreatedStoreViewInGridWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSearchCreatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchCreatedStoreViewInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchCreatedStoreViewInGrid
		$I->see("storeView" . msq("storeViewData"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreViewInGridMessageSearchCreatedStoreViewInGrid
		$I->comment("Exiting Action Group [searchCreatedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->comment("Entering Action Group [clickStoreViewFirstRowInGrid] AdminOpenStoreInFirstRowInStoresGridActionGroup");
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewFirstRowInGridClickStoreViewFirstRowInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStoreViewPageLoadClickStoreViewFirstRowInGrid
		$I->comment("Exiting Action Group [clickStoreViewFirstRowInGrid] AdminOpenStoreInFirstRowInStoresGridActionGroup");
		$I->comment("Update created store view as per requirements");
		$I->comment("Entering Action Group [updateStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewUpdateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1UpdateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreUpdateStoreView
		$I->fillField("#store_name", "Second Store View " . msq("SecondStoreUnique")); // stepKey: enterStoreViewNameUpdateStoreView
		$I->fillField("#store_code", "second_store_view_" . msq("SecondStoreUnique")); // stepKey: enterStoreViewCodeUpdateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusUpdateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewUpdateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewUpdateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalUpdateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalUpdateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteUpdateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalUpdateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalUpdateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageUpdateStoreView
		$I->comment("Exiting Action Group [updateStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Save the updated Store view and verify AssertStoreViewSuccessSaveMessage");
		$I->comment("Entering Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadVerifyAssertStoreViewSuccessSaveMessage
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReload2VerifyAssertStoreViewSuccessSaveMessage
		$I->see("You saved the store view."); // stepKey: seeSavedMessageVerifyAssertStoreViewSuccessSaveMessage
		$I->comment("Exiting Action Group [verifyAssertStoreViewSuccessSaveMessage] AdminCreateStoreViewSaveActionGroup");
		$I->comment("Search updated store view in grid and verify AssertStoreViewInGridMessage");
		$I->comment("Entering Action Group [verifyUpdatedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageVerifyUpdatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadVerifyUpdatedStoreViewInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterVerifyUpdatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterVerifyUpdatedStoreViewInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "Second Store View " . msq("SecondStoreUnique")); // stepKey: fillSearchStoreViewFieldVerifyUpdatedStoreViewInGrid
		$I->waitForPageLoad(90); // stepKey: fillSearchStoreViewFieldVerifyUpdatedStoreViewInGridWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonVerifyUpdatedStoreViewInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonVerifyUpdatedStoreViewInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadVerifyUpdatedStoreViewInGrid
		$I->see("Second Store View " . msq("SecondStoreUnique"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreViewInGridMessageVerifyUpdatedStoreViewInGrid
		$I->comment("Exiting Action Group [verifyUpdatedStoreViewInGrid] AssertStoreViewInGridActionGroup");
		$I->comment("Go to store view form page and verify AssertStoreForm");
		$I->comment("Entering Action Group [verifyStoreViewForm] AssertStoreViewFormActionGroup");
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewFirstRowInGridVerifyStoreViewForm
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStoreViewPageLoadVerifyStoreViewForm
		$I->seeInField("#store_group_id", "Main Website Store"); // stepKey: seeAssertStoreVerifyStoreViewForm
		$I->seeInField("#store_name", "Second Store View " . msq("SecondStoreUnique")); // stepKey: seeAssertStoreViewNameVerifyStoreViewForm
		$I->seeInField("#store_code", "second_store_view_" . msq("SecondStoreUnique")); // stepKey: seeAssertStoreViewCodeVerifyStoreViewForm
		$I->seeInField("#store_is_active", "Enabled"); // stepKey: seeAssertStatusVerifyStoreViewForm
		$I->comment("Exiting Action Group [verifyStoreViewForm] AssertStoreViewFormActionGroup");
		$I->comment("Go to store configuration page and verify AssertStoreBackend");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: goToConfigStoreConfigurationPage
		$I->waitForPageLoad(30); // stepKey: waitForSystemStoreConfigurationPageLoad
		$I->click("#store-change-button"); // stepKey: clickDefaultConfigButton
		$I->waitForPageLoad(30); // stepKey: clickDefaultConfigButtonWaitForPageLoad
		$I->see("storeView" . msq("storeViewData"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertStoreViewInDefaultConfigDropdown
		$I->waitForPageLoad(30); // stepKey: seeAssertStoreViewInDefaultConfigDropdownWaitForPageLoad
		$I->see("Second Store View " . msq("SecondStoreUnique"), "//ul[@class='dropdown-menu']"); // stepKey: seeAssertUpdateStoreViewInDefaultConfigDropdown
		$I->waitForPageLoad(30); // stepKey: seeAssertUpdateStoreViewInDefaultConfigDropdownWaitForPageLoad
		$I->comment("Go to storefront and verify AssertStoreFrontend");
		$I->comment("Entering Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPage
		$I->comment("Exiting Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: selectStoreSwitcher
		$I->waitForPageLoad(30); // stepKey: waitForFirstStoreView
		$I->see("storeView" . msq("storeViewData"), ".active ul.switcher-dropdown"); // stepKey: seeAssertStoreViewOnStorefront
		$I->see("Second Store View " . msq("SecondStoreUnique"), ".active ul.switcher-dropdown"); // stepKey: seeAssertUpdatedStoreViewOnStorefront
	}
}
