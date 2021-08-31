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
 * @Title("MC-14295: Update Store Group and Verify Store View Form")
 * @Description("Test log in to Stores and Update Store Group Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminUpdateStoreGroupAndVerifyStoreViewFormTest.xml<br>")
 * @TestCaseId("MC-14295")
 * @group store
 * @group mtf_migrated
 */
class AdminUpdateStoreGroupAndVerifyStoreViewFormTestCest
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
		$I->comment("Create custom store group");
		$I->comment("Entering Action Group [createNewCustomStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewCustomStoreGroup
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateNewCustomStoreGroup
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateNewCustomStoreGroup
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateNewCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewCustomStoreGroup
		$I->comment("Exiting Action Group [createNewCustomStoreGroup] AdminCreateNewStoreGroupActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteStoreGroup] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteStoreGroup
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreGroupWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldDeleteStoreGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteStoreGroupWaitForPageLoad
		$I->see("store" . msq("customStoreGroup"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteStoreGroup
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteStoreGroupWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteStoreGroup
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteStoreGroup
		$I->comment("Exiting Action Group [deleteStoreGroup] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [deleteUpdatedStoreGroup] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteUpdatedStoreGroup
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteUpdatedStoreGroup
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteUpdatedStoreGroupWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: fillSearchStoreGroupFieldDeleteUpdatedStoreGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteUpdatedStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteUpdatedStoreGroupWaitForPageLoad
		$I->see("Second Store " . msq("SecondStoreGroupUnique"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteUpdatedStoreGroup
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteUpdatedStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteUpdatedStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteUpdatedStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteUpdatedStoreGroupWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteUpdatedStoreGroup
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteUpdatedStoreGroup
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteUpdatedStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteUpdatedStoreGroup
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteUpdatedStoreGroup
		$I->comment("Exiting Action Group [deleteUpdatedStoreGroup] DeleteCustomStoreActionGroup");
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
	 * @Stories({"Update Store Group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Store"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateStoreGroupAndVerifyStoreViewFormTest(AcceptanceTester $I)
	{
		$I->comment("Open created Store group in grid");
		$I->comment("Entering Action Group [openCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageOpenCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadOpenCreatedStoreGroupInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterOpenCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterOpenCreatedStoreGroupInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: fillSearchStoreGroupFieldOpenCreatedStoreGroupInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonOpenCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonOpenCreatedStoreGroupInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadOpenCreatedStoreGroupInGrid
		$I->see("Second Store " . msq("SecondStoreGroupUnique"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreGroupInGridMessageOpenCreatedStoreGroupInGrid
		$I->comment("Exiting Action Group [openCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Entering Action Group [clickFirstRow] AdminOpenFirstRowInStoresGridActionGroup");
		$I->click("(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: clickFirstRowClickFirstRow
		$I->waitForPageLoad(30); // stepKey: AdminSystemStoreGroupPageToOpenClickFirstRow
		$I->comment("Exiting Action Group [clickFirstRow] AdminOpenFirstRowInStoresGridActionGroup");
		$I->comment("Update created Store group as per requirement");
		$I->comment("Entering Action Group [createNewCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateNewCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateNewCustomStoreGroup
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateNewCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateNewCustomStoreGroupWaitForPageLoad
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectMainWebsiteCreateNewCustomStoreGroup
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameCreateNewCustomStoreGroup
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeCreateNewCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: selectStoreStatusCreateNewCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewCustomStoreGroup
		$I->comment("Exiting Action Group [createNewCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->comment("Search updated store group(from above step) in grid and verify AssertStoreGroupInGrid");
		$I->comment("Entering Action Group [seeUpdatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageSeeUpdatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadSeeUpdatedStoreGroupInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterSeeUpdatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterSeeUpdatedStoreGroupInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldSeeUpdatedStoreGroupInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonSeeUpdatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSeeUpdatedStoreGroupInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSeeUpdatedStoreGroupInGrid
		$I->see("store" . msq("customStoreGroup"), "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreGroupInGridMessageSeeUpdatedStoreGroupInGrid
		$I->comment("Exiting Action Group [seeUpdatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Verify updated website name and updated websitecode on website form (AssertStoreGroupForm and AssertStoreGroupOnStoreViewForm)");
		$I->comment("Entering Action Group [seeUpdatedStoreGroupForm] AssertStoreGroupFormActionGroup");
		$I->comment("Admin creates new Store group");
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowSeeUpdatedStoreGroupForm
		$I->waitForPageLoad(30); // stepKey: waitTillAdminSystemStoreGroupPageSeeUpdatedStoreGroupForm
		$I->seeInField("#group_website_id", "Main Website"); // stepKey: seeAssertWebsiteSeeUpdatedStoreGroupForm
		$I->seeInField("#group_name", "store" . msq("customStoreGroup")); // stepKey: seeAssertStoreGroupNameSeeUpdatedStoreGroupForm
		$I->seeInField("#group_code", "store" . msq("customStoreGroup")); // stepKey: seeAssertStoreGroupCodeSeeUpdatedStoreGroupForm
		$I->seeInField("#group_root_category_id", "Default Category"); // stepKey: seeAssertRootCategorySeeUpdatedStoreGroupForm
		$I->comment("Exiting Action Group [seeUpdatedStoreGroupForm] AssertStoreGroupFormActionGroup");
	}
}
