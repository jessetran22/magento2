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
 * @Title("MAGETWO-25812: User should be able to review ordered products with only 'Reports' permission")
 * @Description("User should be able to review ordered products with only 'Reports' permission<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminReviewOrderWithReportsPermissionTest.xml<br>")
 * @TestCaseId("MAGETWO-25812")
 * @group user
 */
class AdminReviewOrderWithReportsPermissionTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
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
		$I->comment("Entering Action Group [createCustomerWithWebsiteAndStoreView] AdminCreateCustomerWithWebsiteAndStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: goToCustomersPageCreateCustomerWithWebsiteAndStoreView
		$I->click("#add"); // stepKey: addNewCustomerCreateCustomerWithWebsiteAndStoreView
		$I->waitForPageLoad(30); // stepKey: addNewCustomerCreateCustomerWithWebsiteAndStoreViewWaitForPageLoad
		$I->selectOption("//select[@name='customer[website_id]']", "WebSite" . msq("NewWebSiteData")); // stepKey: selectWebSiteCreateCustomerWithWebsiteAndStoreView
		$I->fillField("input[name='customer[firstname]']", "John"); // stepKey: FillFirstNameCreateCustomerWithWebsiteAndStoreView
		$I->fillField("input[name='customer[lastname]']", "Doe"); // stepKey: FillLastNameCreateCustomerWithWebsiteAndStoreView
		$I->fillField("input[name='customer[email]']", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: FillEmailCreateCustomerWithWebsiteAndStoreView
		$I->selectOption("//select[@name='customer[sendemail_store_id]']", "StoreView" . msq("NewStoreViewData")); // stepKey: selectStoreViewCreateCustomerWithWebsiteAndStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageCreateCustomerWithWebsiteAndStoreView
		$I->click("//button[@title='Save and Continue Edit']"); // stepKey: saveCustomerCreateCustomerWithWebsiteAndStoreView
		$I->waitForPageLoad(30); // stepKey: waitForCustomersPageCreateCustomerWithWebsiteAndStoreView
		$I->see("You saved the customer."); // stepKey: seeSuccessMessageCreateCustomerWithWebsiteAndStoreView
		$I->click("//a//span[contains(text(), 'Addresses')]"); // stepKey: goToAddressesCreateCustomerWithWebsiteAndStoreView
		$I->waitForPageLoad(30); // stepKey: waitForAddressesCreateCustomerWithWebsiteAndStoreView
		$I->click("//span[text()='Add New Address']"); // stepKey: clickOnAddNewAddressCreateCustomerWithWebsiteAndStoreView
		$I->waitForPageLoad(30); // stepKey: waitForAddressFieldsCreateCustomerWithWebsiteAndStoreView
		$I->click("div[data-index=default_billing] .admin__actions-switch-label"); // stepKey: thickBillingAddressCreateCustomerWithWebsiteAndStoreView
		$I->click("div[data-index=default_shipping] .admin__actions-switch-label"); // stepKey: thickShippingAddressCreateCustomerWithWebsiteAndStoreView
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstNameForAddressCreateCustomerWithWebsiteAndStoreView
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastNameForAddressCreateCustomerWithWebsiteAndStoreView
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'street')]", "368 Broadway St."); // stepKey: fillStreetAddressCreateCustomerWithWebsiteAndStoreView
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'city')]", "New York"); // stepKey: fillCityCreateCustomerWithWebsiteAndStoreView
		$I->selectOption("//div[@class='admin__field-control']//select[contains(@name, 'country_id')]", "United States"); // stepKey: selectCountryCreateCustomerWithWebsiteAndStoreView
		$I->selectOption("//div[@class='admin__field-control']//select[contains(@name, 'region_id')]", "New York"); // stepKey: selectStateCreateCustomerWithWebsiteAndStoreView
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'postcode')]", "10001"); // stepKey: fillZipCreateCustomerWithWebsiteAndStoreView
		$I->fillField("//div[@class='admin__field-control']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillPhoneNumberCreateCustomerWithWebsiteAndStoreView
		$I->click("//button[@title='Save']"); // stepKey: saveAddressCreateCustomerWithWebsiteAndStoreView
		$I->waitForPageLoad(30); // stepKey: waitForAddressSaveCreateCustomerWithWebsiteAndStoreView
		$I->comment("Exiting Action Group [createCustomerWithWebsiteAndStoreView] AdminCreateCustomerWithWebsiteAndStoreViewActionGroup");
		$I->comment("Entering Action Group [searchForProductOnAdmin] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProductOnAdmin
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProductOnAdmin
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProductOnAdmin
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProductOnAdmin
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProductOnAdminWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProductOnAdmin
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProductOnAdmin
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProductOnAdminWaitForPageLoad
		$I->comment("Exiting Action Group [searchForProductOnAdmin] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [productConnectToWebsite] CreatedProductConnectToWebsiteActionGroup");
		$I->click("//div[text()='" . $I->retrieveEntityField('createProduct', 'sku', 'hook') . "']"); // stepKey: openProductProductConnectToWebsite
		$I->waitForPageLoad(30); // stepKey: waitForProductPageProductConnectToWebsite
		$I->scrollTo("div[data-index='websites']"); // stepKey: ScrollToWebsitesProductConnectToWebsite
		$I->waitForPageLoad(30); // stepKey: ScrollToWebsitesProductConnectToWebsiteWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: openWebsitesListProductConnectToWebsite
		$I->waitForPageLoad(30); // stepKey: openWebsitesListProductConnectToWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForWebsitesListProductConnectToWebsite
		$I->click("//label[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]/parent::div//input[@type='checkbox']"); // stepKey: SelectWebsiteProductConnectToWebsite
		$I->click("#save-button"); // stepKey: clickSaveProductProductConnectToWebsite
		$I->waitForPageLoad(30); // stepKey: clickSaveProductProductConnectToWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductConnectToWebsite
		$I->comment("Exiting Action Group [productConnectToWebsite] CreatedProductConnectToWebsiteActionGroup");
		$I->comment("Entering Action Group [createOrder] CreateOrderInStoreChoosingPaymentMethodActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_create/index"); // stepKey: navigateToNewOrderPageCreateOrder
		$I->click("(//td[contains(text(),'John')])[1]"); // stepKey: chooseCustomerCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseCustomerCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageOpenedCreateOrder
		$I->click("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'StoreView" . msq("NewStoreViewData") . "')]"); // stepKey: chooseStoreCreateOrder
		$I->waitForPageLoad(30); // stepKey: chooseStoreCreateOrderWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollToTopCreateOrder
		$I->click("#add_products"); // stepKey: clickOnAddProductsCreateOrder
		$I->waitForPageLoad(60); // stepKey: clickOnAddProductsCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsListForOrderCreateOrder
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createProduct', 'sku', 'hook') . "')]"); // stepKey: chooseTheProductCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseTheProductCreateOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: addSelectedProductToOrderCreateOrder
		$I->waitForPageLoad(30); // stepKey: addSelectedProductToOrderCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedInOrderCreateOrder
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodCreateOrder
		$I->waitForPageLoad(60); // stepKey: openShippingMethodCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsCreateOrder
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodCreateOrder
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodCreateOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsThickenedCreateOrder
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsCreateOrder
		$I->conditionalClick("#p_method_checkmo", "#p_method_checkmo", true); // stepKey: checkCheckMoneyOptionCreateOrder
		$I->waitForPageLoad(30); // stepKey: checkCheckMoneyOptionCreateOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderCreateOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderCreateOrderWaitForPageLoad
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderCreateOrder
		$I->comment("Exiting Action Group [createOrder] CreateOrderInStoreChoosingPaymentMethodActionGroup");
		$I->comment("Entering Action Group [startCreateUserRole] AdminStartCreateUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: openNewAdminRolePageStartCreateUserRole
		$I->waitForElementVisible("#role_name", 30); // stepKey: waitForNameStartCreateUserRole
		$I->fillField("#role_name", "Limited" . msq("limitedRole")); // stepKey: setTheRoleNameStartCreateUserRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: setPasswordStartCreateUserRole
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesStartCreateUserRole
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesStartCreateUserRoleWaitForPageLoad
		$I->selectOption("#all", "Custom"); // stepKey: chooseResourceAccessStartCreateUserRole
		$I->comment("Exiting Action Group [startCreateUserRole] AdminStartCreateUserRoleActionGroup");
		$I->comment("Entering Action Group [setResourceAccess] AdminChooseUserRoleResourceActionGroup");
		$I->waitForElementVisible("//li[@data-id='Magento_Reports::report']//a[text()='Reports']", 30); // stepKey: waitForResourceCheckboxVisibleSetResourceAccess
		$I->waitForPageLoad(30); // stepKey: waitForResourceCheckboxVisibleSetResourceAccessWaitForPageLoad
		$I->click("//li[@data-id='Magento_Reports::report']//a[text()='Reports']"); // stepKey: checkResourceSetResourceAccess
		$I->waitForPageLoad(30); // stepKey: checkResourceSetResourceAccessWaitForPageLoad
		$I->seeCheckboxIsChecked("//li[@data-id='Magento_Reports::report']/input"); // stepKey: seeCheckedResourceSetResourceAccess
		$I->waitForPageLoad(30); // stepKey: seeCheckedResourceSetResourceAccessWaitForPageLoad
		$I->comment("Exiting Action Group [setResourceAccess] AdminChooseUserRoleResourceActionGroup");
		$I->comment("Entering Action Group [saveRole] AdminSaveUserRoleActionGroup");
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButtonSaveRole
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonSaveRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveRole
		$I->see("You saved the role.", "#messages div.message-success"); // stepKey: seeSuccessMessageForSavedRoleSaveRole
		$I->comment("Exiting Action Group [saveRole] AdminSaveUserRoleActionGroup");
		$I->comment("Entering Action Group [createUser] AdminCreateUserWithRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: navigateToNewUserCreateUser
		$I->waitForPageLoad(30); // stepKey: waitForUsersPageCreateUser
		$I->fillField("#user_username", "admin" . msq("NewAdminUser")); // stepKey: enterUserNameCreateUser
		$I->fillField("#user_firstname", "John"); // stepKey: enterFirstNameCreateUser
		$I->fillField("#user_lastname", "Doe"); // stepKey: enterLastNameCreateUser
		$I->fillField("#user_email", "admin" . msq("NewAdminUser") . "@magento.com"); // stepKey: enterEmailCreateUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordCreateUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordCreateUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateUser
		$I->click("//tr//td[contains(text(), 'Limited" . msq("limitedRole") . "')]"); // stepKey: chooseRoleCreateUser
		$I->click("#save"); // stepKey: clickSaveUserCreateUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserCreateUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateUser
		$I->comment("Exiting Action Group [createUser] AdminCreateUserWithRoleActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [logoutAdminUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdminUser
		$I->comment("Exiting Action Group [logoutAdminUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteUser] AdminDeleteCreatedUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageDeleteUser
		$I->click("//td[contains(text(), 'admin" . msq("NewAdminUser") . "')]"); // stepKey: openTheUserDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForSingleUserPageToLoadDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopDeleteUser
		$I->click("//button/span[contains(text(), 'Delete User')]"); // stepKey: clickToDeleteUserDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationPopupDeleteUser
		$I->click(".action-primary.action-accept"); // stepKey: clickToConfirmDeleteUser
		$I->see("You deleted the user."); // stepKey: seeDeleteMessageForUserDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteCreatedUserActionGroup");
		$I->comment("Entering Action Group [clearAdminUserGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearAdminUserGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearAdminUserGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearAdminUserGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRoleGrid
		$I->comment("Entering Action Group [deleteRole] AdminDeleteRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRoleGridDeleteRole
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadDeleteRole
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetFilterButtonBeforeDeleteRole
		$I->waitForPageLoad(10); // stepKey: waitForRolesGridFilterResetBeforeDeleteRole
		$I->fillField("#roleGrid_filter_role_name", "Limited" . msq("limitedRole")); // stepKey: TypeRoleFilterDeleteRole
		$I->waitForElementVisible(".admin__data-grid-header button[title=Search]", 10); // stepKey: waitForFilterSearchButtonBeforeDeleteRole
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickFilterSearchButtonDeleteRole
		$I->waitForPageLoad(10); // stepKey: waitForUserRoleFilterDeleteRole
		$I->waitForElementVisible("//td[contains(@class,'col-role_name') and contains(text(), 'Limited" . msq("limitedRole") . "')]", 10); // stepKey: waitForRoleInRoleGridDeleteRole
		$I->click("//td[contains(@class,'col-role_name') and contains(text(), 'Limited" . msq("limitedRole") . "')]"); // stepKey: clickOnRoleDeleteRole
		$I->waitForPageLoad(10); // stepKey: waitForRolePageToLoadDeleteRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteRole
		$I->waitForElementVisible("//button/span[contains(text(), 'Delete Role')]", 10); // stepKey: waitForDeleteRoleButtonDeleteRole
		$I->click("//button/span[contains(text(), 'Delete Role')]"); // stepKey: clickToDeleteRoleDeleteRole
		$I->waitForPageLoad(5); // stepKey: waitForDeleteConfirmationPopupDeleteRole
		$I->waitForElementVisible("//*[@class='action-primary action-accept']", 10); // stepKey: waitForConfirmButtonDeleteRole
		$I->click("//*[@class='action-primary action-accept']"); // stepKey: clickToConfirmDeleteRole
		$I->waitForPageLoad(10); // stepKey: waitForPageLoadDeleteRole
		$I->see("You deleted the role."); // stepKey: seeSuccessMessageDeleteRole
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadAfterDeleteDeleteRole
		$I->waitForElementVisible("button[title='Reset Filter']", 10); // stepKey: waitForResetFilterButtonAfterDeleteRole
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetFilterButtonAfterDeleteRole
		$I->waitForPageLoad(10); // stepKey: waitForRolesGridFilterResetAfterDeleteRole
		$I->comment("Exiting Action Group [deleteRole] AdminDeleteRoleActionGroup");
		$I->comment("Entering Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("Simple_US_Customer") . "John.Doe@example.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->comment("Entering Action Group [clearCustomerFilters] AdminClearCustomersFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: amOnCustomersPageClearCustomerFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearCustomerFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearCustomerFilters
		$I->waitForPageLoad(30); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearCustomerFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearCustomerFilters] AdminClearCustomersFiltersActionGroup");
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
		$I->comment("Entering Action Group [clearProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilters] AdminClearFiltersActionGroup");
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
	 * @Features({"User"})
	 * @Stories({"Admin with restricted permissions"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReviewOrderWithReportsPermissionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [logAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogAsNewUser
		$I->fillField("#username", "admin" . msq("NewAdminUser")); // stepKey: fillUsernameLogAsNewUser
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLogAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLogAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogAsNewUser
		$I->comment("Exiting Action Group [logAsNewUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [reviewOrder] AdminReviewOrderActionGroup");
		$I->click("//li[@data-ui-id='menu-magento-reports-report']"); // stepKey: openReportsReviewOrder
		$I->waitForPageLoad(5); // stepKey: waitForReportsReviewOrder
		$I->click("//li[@data-ui-id='menu-magento-reports-report-products-sold']"); // stepKey: openOrderedReviewOrder
		$I->waitForPageLoad(5); // stepKey: waitForOrdersPageReviewOrder
		$I->click("//button[@title='Refresh']"); // stepKey: refreshReviewOrder
		$I->waitForPageLoad(30); // stepKey: refreshReviewOrderWaitForPageLoad
		$I->waitForPageLoad(5); // stepKey: waitForOrderListReviewOrder
		$I->scrollTo("//tfoot//th[contains(text(), 'Total')]"); // stepKey: scrollToReviewOrder
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: seeOrderReviewOrder
		$I->comment("Exiting Action Group [reviewOrder] AdminReviewOrderActionGroup");
	}
}
