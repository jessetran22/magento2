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
 * @Title("MC-19306: Delete Default Store View")
 * @Description("Test another store view should be set as default when default store view is deleted<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminDeleteDefaultStoreViewTest.xml<br>")
 * @TestCaseId("MC-19306")
 * @group store
 */
class AdminDeleteDefaultStoreViewTestCest
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
	 * @Stories({"Store creation ('app:config:import' with pre-defined stores) fails during installation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteDefaultStoreViewTest(AcceptanceTester $I)
	{
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
		$I->comment("Change the default store view to the custom store view");
		$I->comment("Entering Action Group [changeDefaultStoreViewToCustomStoreView] ChangeDefaultStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadChangeDefaultStoreViewToCustomStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterChangeDefaultStoreViewToCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetResultChangeDefaultStoreViewToCustomStoreView
		$I->fillField("#storeGrid_filter_group_title", "Main Website Store"); // stepKey: fillStoreGroupFilterChangeDefaultStoreViewToCustomStoreView
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonChangeDefaultStoreViewToCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultChangeDefaultStoreViewToCustomStoreView
		$I->click(".col-group_title>a"); // stepKey: clicksStoreGroupNameChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStorePageToLoadChangeDefaultStoreViewToCustomStoreView
		$I->selectOption("#group_default_store_id", "storeView" . msq("storeViewData")); // stepKey: changeDefaultStoreViewChangeDefaultStoreViewToCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreGroupChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupChangeDefaultStoreViewToCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalChangeDefaultStoreViewToCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteChangeDefaultStoreViewToCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalChangeDefaultStoreViewToCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalChangeDefaultStoreViewToCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: seeForSuccessMessageChangeDefaultStoreViewToCustomStoreView
		$I->see("You saved the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageChangeDefaultStoreViewToCustomStoreView
		$I->comment("Exiting Action Group [changeDefaultStoreViewToCustomStoreView] ChangeDefaultStoreViewActionGroup");
		$I->comment("Delete custom store view");
		$I->comment("Entering Action Group [deleteCustomStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteCustomStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillStoreViewFilterFieldDeleteCustomStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteCustomStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCustomStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteCustomStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteCustomStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteCustomStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteCustomStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteCustomStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteCustomStoreView
		$I->comment("Exiting Action Group [deleteCustomStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Verify that the default store view is now the default store view");
		$I->comment("Entering Action Group [assertDefaultStoreViewActionGroup] AssertDefaultStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageAssertDefaultStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadAssertDefaultStoreViewActionGroup
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterAssertDefaultStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterAssertDefaultStoreViewActionGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetResultAssertDefaultStoreViewActionGroup
		$I->fillField("#storeGrid_filter_group_title", "Main Website Store"); // stepKey: fillStoreGroupFilterAssertDefaultStoreViewActionGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonAssertDefaultStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertDefaultStoreViewActionGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultAssertDefaultStoreViewActionGroup
		$I->click(".col-group_title>a"); // stepKey: clicksStoreGroupNameAssertDefaultStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForStorePageToLoadAssertDefaultStoreViewActionGroup
		$I->seeOptionIsSelected("#group_default_store_id", "Default Store View"); // stepKey: assertDefaultStoreViewAssertDefaultStoreViewActionGroup
		$I->comment("Exiting Action Group [assertDefaultStoreViewActionGroup] AssertDefaultStoreViewActionGroup");
	}
}
