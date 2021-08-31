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
 * @Title("MC-39764: Admin should be able to change customer associated website ID")
 * @Description("Admin should be able to change customer associated website ID<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminChangeCustomerAssociatedWebsiteTest.xml<br>")
 * @TestCaseId("MC-39764")
 * @group customer
 */
class AdminChangeCustomerAssociatedWebsiteTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login to admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create second website");
		$I->comment("Entering Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "WebSite" . msq("NewWebSiteData")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "WebSiteCode" . msq("NewWebSiteData")); // stepKey: enterWebsiteCodeCreateWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsite
		$I->comment("Exiting Action Group [createWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create store group and associate it to second website");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "WebSite" . msq("NewWebSiteData")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "Store" . msq("NewStoreData")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "StoreCode" . msq("NewStoreData")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create store view and associate it to second store group");
		$I->comment("Entering Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateCustomStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Store" . msq("NewStoreData")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "StoreView" . msq("NewStoreViewData")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "StoreViewCode" . msq("NewStoreViewData")); // stepKey: enterStoreViewCodeCreateCustomStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateCustomStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateCustomStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateCustomStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateCustomStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateCustomStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateCustomStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateCustomStoreView
		$I->comment("Exiting Action Group [createCustomStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete custom website");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "WebSite" . msq("NewWebSiteData")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("WebSite" . msq("NewWebSiteData"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
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
		$I->comment("Logout from admin");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Customer"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Stories({"Customer Edit"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminChangeCustomerAssociatedWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Open customer edit page");
		$I->comment("Entering Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPage
		$I->comment("Exiting Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Navigate to \"Account Information\" tab");
		$I->comment("Entering Action Group [openAccountInformationEditPage] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->waitForElementVisible("#tab_customer", 30); // stepKey: waitForAccountInformationTabOpenAccountInformationEditPage
		$I->waitForPageLoad(30); // stepKey: waitForAccountInformationTabOpenAccountInformationEditPageWaitForPageLoad
		$I->click("#tab_customer"); // stepKey: clickAccountInformationTabOpenAccountInformationEditPage
		$I->waitForPageLoad(30); // stepKey: clickAccountInformationTabOpenAccountInformationEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAccountInformationEditPage
		$I->comment("Exiting Action Group [openAccountInformationEditPage] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->comment("Verify that \"Main Website\" is selected in website selector");
		$I->seeOptionIsSelected("//select[@name='customer[website_id]']", "Main Website"); // stepKey: assertThatMainWebsiteIsSelected
		$I->comment("Change customer website to \"Second Website\"");
		$I->comment("Entering Action Group [updateCustomerWebsite] AdminUpdateCustomerWebsiteInCustomerInformationPageActionGroup");
		$I->selectOption("//select[@name='customer[website_id]']", "WebSite" . msq("NewWebSiteData")); // stepKey: changeWebsiteUpdateCustomerWebsite
		$I->comment("Exiting Action Group [updateCustomerWebsite] AdminUpdateCustomerWebsiteInCustomerInformationPageActionGroup");
		$I->comment("Verify that changes are saved successfully");
		$I->comment("Entering Action Group [assertThatChangesAreSavedSuccessfully] AdminSaveCustomerAndAssertSuccessMessage");
		$I->click("#save"); // stepKey: saveCustomerAssertThatChangesAreSavedSuccessfully
		$I->waitForPageLoad(30); // stepKey: saveCustomerAssertThatChangesAreSavedSuccessfullyWaitForPageLoad
		$I->see("You saved the customer", ".message-success"); // stepKey: seeMessageAssertThatChangesAreSavedSuccessfully
		$I->comment("Exiting Action Group [assertThatChangesAreSavedSuccessfully] AdminSaveCustomerAndAssertSuccessMessage");
		$I->comment("Open customer edit page");
		$I->comment("Entering Action Group [openCustomerEditPage2] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPage2
		$I->comment("Exiting Action Group [openCustomerEditPage2] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Navigate to \"Account Information\" tab");
		$I->comment("Entering Action Group [openAccountInformationEditPage2] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->waitForElementVisible("#tab_customer", 30); // stepKey: waitForAccountInformationTabOpenAccountInformationEditPage2
		$I->waitForPageLoad(30); // stepKey: waitForAccountInformationTabOpenAccountInformationEditPage2WaitForPageLoad
		$I->click("#tab_customer"); // stepKey: clickAccountInformationTabOpenAccountInformationEditPage2
		$I->waitForPageLoad(30); // stepKey: clickAccountInformationTabOpenAccountInformationEditPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAccountInformationEditPage2
		$I->comment("Exiting Action Group [openAccountInformationEditPage2] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->comment("Verify that \"Second Website\" is selected in website selector");
		$I->seeOptionIsSelected("//select[@name='customer[website_id]']", "WebSite" . msq("NewWebSiteData")); // stepKey: assertThatSecondWebsiteIsSelected
	}
}
