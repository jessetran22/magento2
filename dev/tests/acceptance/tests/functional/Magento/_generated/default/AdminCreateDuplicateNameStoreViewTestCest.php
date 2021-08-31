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
 * @Title("MC-36863: Admin should be able to create a Store View with the same name")
 * @Description("Admin should be able to create a Store View with the same name<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminCreateDuplicateNameStoreViewTest.xml<br>")
 * @group storeView
 * @TestCaseId("MC-36863")
 */
class AdminCreateDuplicateNameStoreViewTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create two store views with same name, but different codes");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createFirstStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateFirstStoreView
		$I->fillField("#store_name", "sameNameStoreView"); // stepKey: enterStoreViewNameCreateFirstStoreView
		$I->fillField("#store_code", "storeViewCode" . msq("customStoreViewSameNameFirst")); // stepKey: enterStoreViewCodeCreateFirstStoreView
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
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "sameNameStoreView"); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "storeViewCode" . msq("customStoreViewSameNameSecond")); // stepKey: enterStoreViewCodeCreateSecondStoreView
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
		$I->comment("Delete both store views");
		$I->comment("Entering Action Group [deleteFirstStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteFirstStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteFirstStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "sameNameStoreView"); // stepKey: fillStoreViewFilterFieldDeleteFirstStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteFirstStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteFirstStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteFirstStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteFirstStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteFirstStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteFirstStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteFirstStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteFirstStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteFirstStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteFirstStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteFirstStoreView
		$I->comment("Exiting Action Group [deleteFirstStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteSecondStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteSecondStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "sameNameStoreView"); // stepKey: fillStoreViewFilterFieldDeleteSecondStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteSecondStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteSecondStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteSecondStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteSecondStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteSecondStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteSecondStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteSecondStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteSecondStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteSecondStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteSecondStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteSecondStoreView
		$I->comment("Exiting Action Group [deleteSecondStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Features({"Store"})
	 * @Stories({"Create a store view in admin"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDuplicateNameStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("Get Id of store views");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoreViews
		$I->click("tr:nth-of-type(2) > .col-store_title > a"); // stepKey: openFirstViewPAge
		$getStoreViewIdFirst = $I->grabFromCurrentUrl("~/store_id/(\d+)/~"); // stepKey: getStoreViewIdFirst
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoreViewsAgain
		$I->click("tr:nth-of-type(3) > .col-store_title > a"); // stepKey: openSecondViewPAge
		$getStoreViewIdSecond = $I->grabFromCurrentUrl("~/store_id/(\d+)/~"); // stepKey: getStoreViewIdSecond
		$I->comment("Go to catalog -> product grid, open the filter and check the listed store view");
		$I->comment("Entering Action Group [checkFirstStoreView] AdminCheckStoreViewOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: OpenProductCatalogPageCheckFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageCheckFirstStoreView
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersButtonCheckFirstStoreView
		$I->click("//select[@name='store_id']"); // stepKey: clickStoreViewSwitchDropdownCheckFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewSwitchDropdownCheckFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("//select[@name='store_id']", 30); // stepKey: waitForWebsiteAreVisibleCheckFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleCheckFirstStoreViewWaitForPageLoad
		$I->seeElement(".admin__data-grid-outer-wrap select[name='store_id'] > option[value='{$getStoreViewIdFirst}']"); // stepKey: seeStoreViewOptionCheckFirstStoreView
		$I->comment("Exiting Action Group [checkFirstStoreView] AdminCheckStoreViewOptionsActionGroup");
		$I->comment("Entering Action Group [checkSecondStoreView] AdminCheckStoreViewOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: OpenProductCatalogPageCheckSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageCheckSecondStoreView
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersButtonCheckSecondStoreView
		$I->click("//select[@name='store_id']"); // stepKey: clickStoreViewSwitchDropdownCheckSecondStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewSwitchDropdownCheckSecondStoreViewWaitForPageLoad
		$I->waitForElementVisible("//select[@name='store_id']", 30); // stepKey: waitForWebsiteAreVisibleCheckSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleCheckSecondStoreViewWaitForPageLoad
		$I->seeElement(".admin__data-grid-outer-wrap select[name='store_id'] > option[value='{$getStoreViewIdSecond}']"); // stepKey: seeStoreViewOptionCheckSecondStoreView
		$I->comment("Exiting Action Group [checkSecondStoreView] AdminCheckStoreViewOptionsActionGroup");
	}
}
