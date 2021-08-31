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
 * @Title("MC-22173: Newsletter subscriptions per website")
 * @Description("Admin should be able to subscribe customer to newsletters on each website separately<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCustomerSubscribeNewsletterPerWebsiteTest.xml<br>")
 * @TestCaseId("MC-22173")
 * @group customer
 */
class AdminCustomerSubscribeNewsletterPerWebsiteTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("setConfigCustomerAccountToGlobal", "hook", "CustomerAccountSharingGlobal", [], []); // stepKey: setConfigCustomerAccountToGlobal
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
		$I->fillField("#storeGrid_filter_store_title", "StoreView" . msq("NewStoreViewData")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
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
		$I->comment("Entering Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteCustomer
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteCustomer
		$I->click("//td[@class='data-grid-checkbox-cell']"); // stepKey: clickOnEditButton1DeleteCustomer
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsDropdownDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickActionsDropdownDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: clickDeleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkToVisibleDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForOkToVisibleDeleteCustomerWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkConfirmationButtonDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickOkConfirmationButtonDeleteCustomerWaitForPageLoad
		$I->waitForElementVisible("//*[@class='message message-success success']", 30); // stepKey: waitForSuccessfullyDeletedMessageDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] DeleteCustomerByEmailActionGroup");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Custom Website" . msq("secondCustomWebsite")); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see("Custom Website" . msq("secondCustomWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->createEntity("setConfigCustomerAccountDefault", "hook", "CustomerAccountSharingDefault", [], []); // stepKey: setConfigCustomerAccountDefault
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
	 * @Stories({"Customer Subscriptions"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCustomerSubscribeNewsletterPerWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Create a new Store View");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "StoreView" . msq("NewStoreViewData")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "StoreViewCode" . msq("NewStoreViewData")); // stepKey: enterStoreViewCodeCreateStoreView
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
		$I->comment("Switch to the new Store View on storefront");
		$I->comment("Entering Action Group [amOnHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnHomePage
		$I->comment("Exiting Action Group [amOnHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreView
		$I->click("li.view-StoreViewCode" . msq("NewStoreViewData") . ">a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Create a new customer and sign up newsletter on the new Store View");
		$I->comment("Entering Action Group [createCustomer] StorefrontCreateCustomerSignedUpNewsletterActionGroup");
		$I->amOnPage("/"); // stepKey: amOnStorefrontPageCreateCustomer
		$I->waitForPageLoad(30); // stepKey: waitForNavigateToCustomersPageLoadCreateCustomer
		$I->click("//div[@class='panel wrapper']//li/a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAccountLinkCreateCustomer
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAccountLinkCreateCustomerWaitForPageLoad
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameCreateCustomer
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameCreateCustomer
		$I->checkOption("//span[contains(text(), 'Sign Up for Newsletter')]"); // stepKey: checkSignUpForNewsletterCreateCustomer
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailCreateCustomer
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordCreateCustomer
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordCreateCustomer
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonCreateCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonCreateCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonToLoadCreateCustomer
		$I->comment("Exiting Action Group [createCustomer] StorefrontCreateCustomerSignedUpNewsletterActionGroup");
		$I->comment("Go to the customer edit page on admin area");
		$I->comment("Entering Action Group [filterCustomerGrid] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterCustomerGrid
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterCustomerGrid
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCustomerGrid
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCustomerGridWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerGrid
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerGridWaitForPageLoad
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailFilterCustomerGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterCustomerGrid
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterCustomerGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterCustomerGrid
		$I->comment("Exiting Action Group [filterCustomerGrid] AdminFilterCustomerByEmail");
		$I->comment("Entering Action Group [clickToEditCustomerPage] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickToEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickToEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickToEditCustomerPage
		$I->comment("Exiting Action Group [clickToEditCustomerPage] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$grabCustomerId = $I->grabFromCurrentUrl("~(\d+)/~"); // stepKey: grabCustomerId
		$I->comment("Assert that created customer is subscribed to newsletter on the new Store View");
		$I->comment("Entering Action Group [assertSubscribedToNewsletter] AdminAssertCustomerIsSubscribedToNewslettersAndSelectedStoreView");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickToNewsletterTabHeaderAssertSubscribedToNewsletter
		$I->waitForPageLoad(30); // stepKey: clickToNewsletterTabHeaderAssertSubscribedToNewsletterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShowNewsletterTabAssertSubscribedToNewsletter
		$I->seeCheckboxIsChecked("//div[@class='admin__field-control control']//input[@name='subscription_status[1]']"); // stepKey: assertSubscribedToNewsletterAssertSubscribedToNewsletter
		$I->seeOptionIsSelected("//div[@class='admin__field-control control']//select[@name='subscription_store[1]']", "StoreView" . msq("NewStoreViewData")); // stepKey: assertSubscribedStoreViewAssertSubscribedToNewsletter
		$I->comment("Exiting Action Group [assertSubscribedToNewsletter] AdminAssertCustomerIsSubscribedToNewslettersAndSelectedStoreView");
		$I->comment("Create second website");
		$I->comment("Entering Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateSecondWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Custom Website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteNameCreateSecondWebsite
		$I->fillField("#website_code", "custom_website" . msq("secondCustomWebsite")); // stepKey: enterWebsiteCodeCreateSecondWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateSecondWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateSecondWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateSecondWebsite
		$I->comment("Exiting Action Group [createSecondWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Create second store");
		$I->comment("Entering Action Group [createSecondStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateSecondStoreGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreGroup
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Custom Website" . msq("secondCustomWebsite")); // stepKey: selectWebsiteCreateSecondStoreGroup
		$I->fillField("#group_name", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupNameCreateSecondStoreGroup
		$I->fillField("#group_code", "second_store_" . msq("SecondStoreGroupUnique")); // stepKey: enterStoreGroupCodeCreateSecondStoreGroup
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateSecondStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateSecondStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateSecondStoreGroupWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateSecondStoreGroup
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateSecondStoreGroup
		$I->comment("Exiting Action Group [createSecondStoreGroup] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create second store view");
		$I->comment("Entering Action Group [createSecondStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateSecondStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateSecondStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Second Store " . msq("SecondStoreGroupUnique")); // stepKey: selectStoreCreateSecondStoreView
		$I->fillField("#store_name", "Second Store View " . msq("SecondStoreUnique")); // stepKey: enterStoreViewNameCreateSecondStoreView
		$I->fillField("#store_code", "second_store_view_" . msq("SecondStoreUnique")); // stepKey: enterStoreViewCodeCreateSecondStoreView
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
		$I->comment("Grab second website id into \$grabFromCurrentUrlGetSecondWebsiteId");
		$I->comment("Entering Action Group [getSecondWebsiteId] AdminGetWebsiteIdActionGroup");
		$I->comment("Get Website_id");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnTheStorePageGetSecondWebsiteId
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersGetSecondWebsiteId
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGetSecondWebsiteIdWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Custom Website" . msq("secondCustomWebsite")); // stepKey: fillSearchWebsiteFieldGetSecondWebsiteId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGetSecondWebsiteId
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGetSecondWebsiteIdWaitForPageLoad
		$I->see("Custom Website" . msq("secondCustomWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundGetSecondWebsiteId
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingWebsiteGetSecondWebsiteId
		$grabFromCurrentUrlGetSecondWebsiteId = $I->grabFromCurrentUrl("~(\d+)/~"); // stepKey: grabFromCurrentUrlGetSecondWebsiteId
		$I->comment("Exiting Action Group [getSecondWebsiteId] AdminGetWebsiteIdActionGroup");
		$I->comment("Go to the customer edit page on admin area");
		$I->comment("Entering Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/$grabCustomerId"); // stepKey: openCustomerEditPageOpenCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPage
		$I->comment("Exiting Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Assert that customer still subscribed to newsletter on default website");
		$I->comment("Entering Action Group [assertStillSubscribedToNewsletter] AdminAssertCustomerIsSubscribedToNewsletters");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickToNewsletterTabHeaderAssertStillSubscribedToNewsletter
		$I->waitForPageLoad(30); // stepKey: clickToNewsletterTabHeaderAssertStillSubscribedToNewsletterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShowNewsletterTabAssertStillSubscribedToNewsletter
		$I->seeCheckboxIsChecked("//div[@class='admin__field-control control']//input[@name='subscription_status[1]']"); // stepKey: assertSubscribedToNewsletterAssertStillSubscribedToNewsletter
		$I->comment("Exiting Action Group [assertStillSubscribedToNewsletter] AdminAssertCustomerIsSubscribedToNewsletters");
		$I->comment("Subscribe to newsletters customer on the second website");
		$I->comment("Entering Action Group [subscribeToNewsletterSecondWebsite] AdminSubscribeCustomerToNewslettersAndSelectStoreView");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickToNewsletterTabHeaderSubscribeToNewsletterSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickToNewsletterTabHeaderSubscribeToNewsletterSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShowNewsletterTabSubscribeToNewsletterSecondWebsite
		$I->checkOption("//div[@class='admin__field-control control']//input[@name='subscription_status[$grabFromCurrentUrlGetSecondWebsiteId]']"); // stepKey: subscribeToNewsletterSubscribeToNewsletterSecondWebsite
		$I->selectOption("//div[@class='admin__field-control control']//select[@name='subscription_store[$grabFromCurrentUrlGetSecondWebsiteId]']", "Second Store View " . msq("SecondStoreUnique")); // stepKey: selectSubscribeStoreViewSubscribeToNewsletterSecondWebsite
		$I->click("#save_and_continue"); // stepKey: saveAndContinueSubscribeToNewsletterSecondWebsite
		$I->waitForPageLoad(30); // stepKey: saveAndContinueSubscribeToNewsletterSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSubscribeToNewsletterSecondWebsite
		$I->see("You saved the customer."); // stepKey: seeSuccessMessageSubscribeToNewsletterSecondWebsite
		$I->comment("Exiting Action Group [subscribeToNewsletterSecondWebsite] AdminSubscribeCustomerToNewslettersAndSelectStoreView");
		$I->comment("Assert that created customer is subscribed to newsletter on second website");
		$I->comment("Entering Action Group [assertSubscribedToNewsletterSecondWebsite] AdminAssertCustomerIsSubscribedToNewslettersAndSelectedStoreView");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickToNewsletterTabHeaderAssertSubscribedToNewsletterSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickToNewsletterTabHeaderAssertSubscribedToNewsletterSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShowNewsletterTabAssertSubscribedToNewsletterSecondWebsite
		$I->seeCheckboxIsChecked("//div[@class='admin__field-control control']//input[@name='subscription_status[$grabFromCurrentUrlGetSecondWebsiteId]']"); // stepKey: assertSubscribedToNewsletterAssertSubscribedToNewsletterSecondWebsite
		$I->seeOptionIsSelected("//div[@class='admin__field-control control']//select[@name='subscription_store[$grabFromCurrentUrlGetSecondWebsiteId]']", "Second Store View " . msq("SecondStoreUnique")); // stepKey: assertSubscribedStoreViewAssertSubscribedToNewsletterSecondWebsite
		$I->comment("Exiting Action Group [assertSubscribedToNewsletterSecondWebsite] AdminAssertCustomerIsSubscribedToNewslettersAndSelectedStoreView");
	}
}
