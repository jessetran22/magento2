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
 * @Title("MC-14296: Update Store Group, Accept Alert and Verify Store View Form")
 * @Description("Test log in to Stores and Update Store Group Test<h3>Test files</h3>app/code/Magento/Store/Test/Mftf/Test/AdminUpdateStoreGroupAcceptAlertAndVerifyStoreViewFormTest.xml<br>")
 * @TestCaseId("MC-14296")
 * @group store
 * @group mtf_migrated
 */
class AdminUpdateStoreGroupAcceptAlertAndVerifyStoreViewFormTestCest
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
		$I->comment("Create root category");
		$I->createEntity("rootCategory", "hook", "NewRootCategory", [], []); // stepKey: rootCategory
		$I->createEntity("category", "hook", "SimpleRootSubCategory", ["rootCategory"], []); // stepKey: category
		$I->comment("Create website");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create custom store group");
		$I->comment("Entering Action Group [createCustomStoreGroup] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStoreGroup
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreGroupWaitForPageLoad
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectMainWebsiteCreateCustomStoreGroup
		$I->fillField("#group_name", "NewStore"); // stepKey: fillStoreNameCreateCustomStoreGroup
		$I->fillField("#group_code", "NewStore"); // stepKey: fillStoreCodeCreateCustomStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: selectStoreStatusCreateCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStoreGroup
		$I->comment("Exiting Action Group [createCustomStoreGroup] CreateCustomStoreActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete website");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Delete root category");
		$I->deleteEntity("rootCategory", "hook"); // stepKey: deleteRootCategory
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
	public function AdminUpdateStoreGroupAcceptAlertAndVerifyStoreViewFormTest(AcceptanceTester $I)
	{
		$I->comment("Open created Store group in grid");
		$I->comment("Entering Action Group [openCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageOpenCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminSystemStorePageLoadOpenCreatedStoreGroupInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterOpenCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterOpenCreatedStoreGroupInGridWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "NewStore"); // stepKey: fillSearchStoreGroupFieldOpenCreatedStoreGroupInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonOpenCreatedStoreGroupInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonOpenCreatedStoreGroupInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadOpenCreatedStoreGroupInGrid
		$I->see("NewStore", "(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: seeAssertStoreGroupInGridMessageOpenCreatedStoreGroupInGrid
		$I->comment("Exiting Action Group [openCreatedStoreGroupInGrid] AssertStoreGroupInGridActionGroup");
		$I->comment("Entering Action Group [clickFirstRow] AdminOpenFirstRowInStoresGridActionGroup");
		$I->click("(//*[@id='storeGrid_table']/tbody/tr)[1]"); // stepKey: clickFirstRowClickFirstRow
		$I->waitForPageLoad(30); // stepKey: AdminSystemStoreGroupPageToOpenClickFirstRow
		$I->comment("Exiting Action Group [clickFirstRow] AdminOpenFirstRowInStoresGridActionGroup");
		$I->comment("Update created Store group as per requirement and accept alert message");
		$I->comment("Entering Action Group [updateCustomStoreGroup] EditCustomStoreGroupAcceptWarningMessageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageUpdateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageUpdateCustomStoreGroup
		$I->click(".col-group_title>a"); // stepKey: clickFirstRowUpdateCustomStoreGroup
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectMainWebsiteUpdateCustomStoreGroup
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameUpdateCustomStoreGroup
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeUpdateCustomStoreGroup
		$I->selectOption("#group_root_category_id", $I->retrieveEntityField('rootCategory', 'name', 'test')); // stepKey: selectStoreStatusUpdateCustomStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupUpdateCustomStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupUpdateCustomStoreGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForWarningMessageToAppearUpdateCustomStoreGroup
		$I->click("//footer[@class='modal-footer']//button[@class='action-primary action-accept']/span"); // stepKey: seeAssertAlertWarningMessageUpdateCustomStoreGroup
		$I->waitForPageLoad(30); // stepKey: seeAssertAlertWarningMessageUpdateCustomStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadUpdateCustomStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageUpdateCustomStoreGroup
		$I->comment("Admin creates new Store group");
		$I->comment("Exiting Action Group [updateCustomStoreGroup] EditCustomStoreGroupAcceptWarningMessageActionGroup");
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
		$I->seeInField("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: seeAssertWebsiteSeeUpdatedStoreGroupForm
		$I->seeInField("#group_name", "store" . msq("customStoreGroup")); // stepKey: seeAssertStoreGroupNameSeeUpdatedStoreGroupForm
		$I->seeInField("#group_code", "store" . msq("customStoreGroup")); // stepKey: seeAssertStoreGroupCodeSeeUpdatedStoreGroupForm
		$I->seeInField("#group_root_category_id", $I->retrieveEntityField('rootCategory', 'name', 'test')); // stepKey: seeAssertRootCategorySeeUpdatedStoreGroupForm
		$I->comment("Exiting Action Group [seeUpdatedStoreGroupForm] AssertStoreGroupFormActionGroup");
	}
}
