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
 * @Title("MAGETWO-96710: Check that attribute text swatches can be filed")
 * @Description("Check that attribute text swatches can be filed<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminAttributeTextSwatchesCanBeFiledTest.xml<br>")
 * @TestCaseId("MAGETWO-96710")
 * @group backend
 * @group ui
 */
class AdminAttributeTextSwatchesCanBeFiledTestCest
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
		$I->comment("Delete all 10 store views");
		$I->comment("Entering Action Group [deleteStoreView1] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView1
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView1WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "store" . msq("customStore")); // stepKey: fillStoreViewFilterFieldDeleteStoreView1
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView1WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView1WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView1
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView1WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView1
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView1
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView1
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView1
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView1
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView1
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView1
		$I->comment("Exiting Action Group [deleteStoreView1] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView2] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView2
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView2WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "StoreView" . msq("NewStoreViewData")); // stepKey: fillStoreViewFilterFieldDeleteStoreView2
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView2WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView2WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView2
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView2WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView2
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView2
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView2
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView2
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView2
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView2
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView2
		$I->comment("Exiting Action Group [deleteStoreView2] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView3] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView3
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView3
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView3
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView3WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData")); // stepKey: fillStoreViewFilterFieldDeleteStoreView3
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView3WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView3
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView3WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView3
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView3
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView3
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView3WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView3
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView3
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView3WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView3
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView3
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView3
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView3
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView3
		$I->comment("Exiting Action Group [deleteStoreView3] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView4] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView4
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView4
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView4
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView4WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData1")); // stepKey: fillStoreViewFilterFieldDeleteStoreView4
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView4WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView4
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView4WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView4
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView4
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView4
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView4WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView4
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView4
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView4WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView4
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView4
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView4WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView4
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView4
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView4
		$I->comment("Exiting Action Group [deleteStoreView4] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView5] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView5
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView5
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView5
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView5WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData2")); // stepKey: fillStoreViewFilterFieldDeleteStoreView5
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView5WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView5
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView5WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView5
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView5
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView5
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView5WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView5
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView5
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView5WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView5
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView5
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView5WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView5
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView5
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView5
		$I->comment("Exiting Action Group [deleteStoreView5] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView6] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView6
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView6
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView6
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView6WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData3")); // stepKey: fillStoreViewFilterFieldDeleteStoreView6
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView6WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView6
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView6WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView6
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView6
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView6
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView6WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView6
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView6
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView6WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView6
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView6
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView6WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView6
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView6
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView6
		$I->comment("Exiting Action Group [deleteStoreView6] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView7] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView7
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView7
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView7
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView7WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData4")); // stepKey: fillStoreViewFilterFieldDeleteStoreView7
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView7WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView7
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView7WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView7
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView7
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView7
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView7WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView7
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView7
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView7WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView7
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView7
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView7WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView7
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView7
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView7
		$I->comment("Exiting Action Group [deleteStoreView7] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView8] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView8
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView8
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView8
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView8WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData5")); // stepKey: fillStoreViewFilterFieldDeleteStoreView8
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView8WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView8
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView8WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView8
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView8
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView8
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView8WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView8
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView8
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView8WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView8
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView8
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView8WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView8
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView8
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView8
		$I->comment("Exiting Action Group [deleteStoreView8] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView9] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView9
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView9
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView9
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView9WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData6")); // stepKey: fillStoreViewFilterFieldDeleteStoreView9
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView9WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView9
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView9WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView9
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView9
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView9
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView9WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView9
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView9
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView9WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView9
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView9
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView9WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView9
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView9
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView9
		$I->comment("Exiting Action Group [deleteStoreView9] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreView10] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView10
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView10
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView10
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreView10WaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "storeView" . msq("storeViewData7")); // stepKey: fillStoreViewFilterFieldDeleteStoreView10
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreView10WaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView10
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreView10WaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView10
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView10
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView10
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreView10WaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView10
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView10
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreView10WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView10
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView10
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreView10WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView10
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView10
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView10
		$I->comment("Exiting Action Group [deleteStoreView10] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Unable to add more attributes in size"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAttributeTextSwatchesCanBeFiledTest(AcceptanceTester $I)
	{
		$I->comment("Create 10 store views");
		$I->comment("Entering Action Group [createStoreView1] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView1
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView1
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateStoreView1
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateStoreView1
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView1
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView1
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView1
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView1WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView1
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView1
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView1WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView1
		$I->comment("Exiting Action Group [createStoreView1] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView2] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView2
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView2
		$I->fillField("#store_name", "StoreView" . msq("NewStoreViewData")); // stepKey: enterStoreViewNameCreateStoreView2
		$I->fillField("#store_code", "StoreViewCode" . msq("NewStoreViewData")); // stepKey: enterStoreViewCodeCreateStoreView2
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView2
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView2
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView2
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView2WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView2
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView2
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView2WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView2
		$I->comment("Exiting Action Group [createStoreView2] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView3] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView3
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView3
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateStoreView3
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateStoreView3
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView3
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView3
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView3WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView3
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView3WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView3
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView3
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView3WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView3
		$I->comment("Exiting Action Group [createStoreView3] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView4] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView4
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView4
		$I->fillField("#store_name", "storeView" . msq("storeViewData1")); // stepKey: enterStoreViewNameCreateStoreView4
		$I->fillField("#store_code", "storeView" . msq("storeViewData1")); // stepKey: enterStoreViewCodeCreateStoreView4
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView4
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView4
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView4WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView4
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView4WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView4
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView4
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView4WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView4
		$I->comment("Exiting Action Group [createStoreView4] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView5] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView5
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView5
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView5
		$I->fillField("#store_name", "storeView" . msq("storeViewData2")); // stepKey: enterStoreViewNameCreateStoreView5
		$I->fillField("#store_code", "storeView" . msq("storeViewData2")); // stepKey: enterStoreViewCodeCreateStoreView5
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView5
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView5
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView5WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView5
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView5WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView5
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView5
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView5WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView5
		$I->comment("Exiting Action Group [createStoreView5] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView6] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView6
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView6
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView6
		$I->fillField("#store_name", "storeView" . msq("storeViewData3")); // stepKey: enterStoreViewNameCreateStoreView6
		$I->fillField("#store_code", "storeView" . msq("storeViewData3")); // stepKey: enterStoreViewCodeCreateStoreView6
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView6
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView6
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView6WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView6
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView6WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView6
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView6
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView6WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView6
		$I->comment("Exiting Action Group [createStoreView6] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView7] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView7
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView7
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView7
		$I->fillField("#store_name", "storeView" . msq("storeViewData4")); // stepKey: enterStoreViewNameCreateStoreView7
		$I->fillField("#store_code", "storeView" . msq("storeViewData4")); // stepKey: enterStoreViewCodeCreateStoreView7
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView7
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView7
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView7WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView7
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView7WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView7
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView7
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView7WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView7
		$I->comment("Exiting Action Group [createStoreView7] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView8] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView8
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView8
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView8
		$I->fillField("#store_name", "storeView" . msq("storeViewData5")); // stepKey: enterStoreViewNameCreateStoreView8
		$I->fillField("#store_code", "storeView" . msq("storeViewData5")); // stepKey: enterStoreViewCodeCreateStoreView8
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView8
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView8
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView8WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView8
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView8WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView8
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView8
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView8WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView8
		$I->comment("Exiting Action Group [createStoreView8] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView9] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView9
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView9
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView9
		$I->fillField("#store_name", "storeView" . msq("storeViewData6")); // stepKey: enterStoreViewNameCreateStoreView9
		$I->fillField("#store_code", "storeView" . msq("storeViewData6")); // stepKey: enterStoreViewCodeCreateStoreView9
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView9
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView9
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView9WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView9
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView9WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView9
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView9
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView9WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView9
		$I->comment("Exiting Action Group [createStoreView9] AdminCreateStoreViewActionGroup");
		$I->comment("Entering Action Group [createStoreView10] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView10
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView10
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView10
		$I->fillField("#store_name", "storeView" . msq("storeViewData7")); // stepKey: enterStoreViewNameCreateStoreView10
		$I->fillField("#store_code", "storeView" . msq("storeViewData7")); // stepKey: enterStoreViewCodeCreateStoreView10
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView10
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView10
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreView10WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView10
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreView10WaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView10
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView10
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreView10WaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView10
		$I->comment("Exiting Action Group [createStoreView10] AdminCreateStoreViewActionGroup");
		$I->comment("Navigate to Product attribute page");
		$I->comment("Entering Action Group [navigateToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageNavigateToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToNewProductAttributePage
		$I->comment("Exiting Action Group [navigateToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->fillField("#attribute_label", "test_label"); // stepKey: fillDefaultLabel
		$I->selectOption("#frontend_input", "Text Swatch"); // stepKey: selectInputType
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoad
		$I->comment("Fill Swatch and Description fields for Admin");
		$I->fillField("//th[contains(@class, 'col-swatch')]/span[contains(text(), 'Admin')]/ancestor::thead/following-sibling::tbody//input[@placeholder='Swatch']", "test"); // stepKey: fillSwatchForAdmin
		$I->fillField("//th[contains(@class, 'col-swatch')]/span[contains(text(), 'Admin')]/ancestor::thead/following-sibling::tbody//input[@placeholder='Description']", "test"); // stepKey: fillDescriptionForAdmin
		$I->comment("Grab value Swatch and Description fields for Admin");
		$grabSwatchForAdmin = $I->grabValueFrom("//th[contains(@class, 'col-swatch')]/span[contains(text(), 'Admin')]/ancestor::thead/following-sibling::tbody//input[@placeholder='Swatch']"); // stepKey: grabSwatchForAdmin
		$grabDescriptionForAdmin = $I->grabValueFrom("//th[contains(@class, 'col-swatch')]/span[contains(text(), 'Admin')]/ancestor::thead/following-sibling::tbody//input[@placeholder='Description']"); // stepKey: grabDescriptionForAdmin
		$I->comment("Check that Swatch and Description fields for Admin are not empty");
		$I->assertNotEmpty($grabSwatchForAdmin); // stepKey: checkSwatchFieldForAdmin
		$I->assertNotEmpty($grabDescriptionForAdmin); // stepKey: checkDescriptionFieldForAdmin
	}
}
