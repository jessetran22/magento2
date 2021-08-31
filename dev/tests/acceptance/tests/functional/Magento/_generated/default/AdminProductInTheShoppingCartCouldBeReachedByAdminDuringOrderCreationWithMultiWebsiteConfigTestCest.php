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
 * @Title("MC-25877: Product in the shopping cart could be reached by admin during order creation with multi website config")
 * @Description("Product in the shopping cart could be reached by admin during order creation with multi website config<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminProductInTheShoppingCartCouldBeReachedByAdminDuringOrderCreationWithMultiWebsiteConfigTest.xml<br>")
 * @TestCaseId("MC-25877")
 * @group sales
 */
class AdminProductInTheShoppingCartCouldBeReachedByAdminDuringOrderCreationWithMultiWebsiteConfigTestCest
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
		$addStoreCodeToUrlEnable = $I->magentoCLI("config:set web/url/use_store 1", 60); // stepKey: addStoreCodeToUrlEnable
		$I->comment($addStoreCodeToUrlEnable);
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
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
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsite
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
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
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
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateCustomStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateCustomStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateCustomStoreView
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
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'hook')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [assignProductToSecondWebsite] ProductSetWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesAssignProductToSecondWebsite
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesAssignProductToSecondWebsiteWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']", false); // stepKey: clickToOpenProductInWebsiteAssignProductToSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedAssignProductToSecondWebsite
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteAssignProductToSecondWebsite
		$I->click("#save-button"); // stepKey: clickSaveProductAssignProductToSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickSaveProductAssignProductToSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: waitForProducrSavedAssignProductToSecondWebsite
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSaveSuccessMessageAssignProductToSecondWebsite
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveSuccessMessageAssignProductToSecondWebsite
		$I->comment("Exiting Action Group [assignProductToSecondWebsite] ProductSetWebsiteActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$addStoreCodeToUrlDisable = $I->magentoCLI("config:set web/url/use_store 0", 60); // stepKey: addStoreCodeToUrlDisable
		$I->comment($addStoreCodeToUrlDisable);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Sales"})
	 * @Stories({"Admin create order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductInTheShoppingCartCouldBeReachedByAdminDuringOrderCreationWithMultiWebsiteConfigTest(AcceptanceTester $I)
	{
		$I->comment("Create customer account for Second Website");
		$I->comment("Entering Action Group [goToCreateCustomerPage] StorefrontOpenCustomerAccountCreatePageUsingStoreCodeInUrlActionGroup");
		$I->amOnPage("/store" . msq("customStore") . "//customer/account/create/"); // stepKey: goToCustomerAccountCreatePageGoToCreateCustomerPage
		$I->comment("Exiting Action Group [goToCreateCustomerPage] StorefrontOpenCustomerAccountCreatePageUsingStoreCodeInUrlActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with store" . msq("customStoreGroup") . ".", "#maincontent .message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Open product page and add to cart");
		$I->comment("Entering Action Group [openProductPageUsingStoreCodeInUrl] StorefrontOpenProductPageUsingStoreCodeInUrlActionGroup");
		$I->amOnPage("/store" . msq("customStore") . "/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageUsingStoreCodeInUrlOpenProductPageUsingStoreCodeInUrl
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageUsingStoreCodeInUrl
		$I->comment("Exiting Action Group [openProductPageUsingStoreCodeInUrl] StorefrontOpenProductPageUsingStoreCodeInUrlActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonAddProductToCart
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonAddProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddToTheCartActionGroup");
		$I->comment("Create new order for existing Customer And Store");
		$I->comment("Entering Action Group [createNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadCreateNewOrder
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleCreateNewOrder
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadCreateNewOrder
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersCreateNewOrderWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: filterEmailCreateNewOrder
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadCreateNewOrder
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadCreateNewOrder
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'store" . msq("customStore") . "')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'store" . msq("customStore") . "')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectCreateNewOrder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleCreateNewOrder
		$I->comment("Exiting Action Group [createNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Assert product in Shopping cart section");
		$I->comment("Entering Action Group [seeProductInShoppingCart] AdminAssertProductInShoppingCartSectionActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "#sidebar_data_cart"); // stepKey: seeProductInShoppingCartSeeProductInShoppingCart
		$I->comment("Exiting Action Group [seeProductInShoppingCart] AdminAssertProductInShoppingCartSectionActionGroup");
		$I->comment("Move product to the order from shopping cart");
		$I->comment("Entering Action Group [addProductToItemsOrderedFromShoppingCart] AdminMoveProductToItemsOrderedFromShoppingCartActionGroup");
		$I->waitForElementVisible("//div[@id='order-sidebar_cart']//tr[td[.='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_cart_item]')]", 30); // stepKey: waitForAddToOrderCheckBoxAddProductToItemsOrderedFromShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForAddToOrderCheckBoxAddProductToItemsOrderedFromShoppingCartWaitForPageLoad
		$I->click("//div[@id='order-sidebar_cart']//tr[td[.='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_cart_item]')]"); // stepKey: selectProductAddProductToItemsOrderedFromShoppingCart
		$I->waitForPageLoad(30); // stepKey: selectProductAddProductToItemsOrderedFromShoppingCartWaitForPageLoad
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickOnUpdateButtonAddProductToItemsOrderedFromShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateButtonAddProductToItemsOrderedFromShoppingCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminCreateOrderShoppingCartSectionPageLoadAddProductToItemsOrderedFromShoppingCart
		$I->comment("Exiting Action Group [addProductToItemsOrderedFromShoppingCart] AdminMoveProductToItemsOrderedFromShoppingCartActionGroup");
		$I->comment("Fill customer address information");
		$I->comment("Entering Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", "John"); // stepKey: fillFirstNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", "Doe"); // stepKey: fillLastNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Austin"); // stepKey: fillCityFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "Texas"); // stepKey: fillStateFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "78729"); // stepKey: fillPostalCodeFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerAddressWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->comment("Select shipping method");
		$I->comment("Entering Action Group [selectFlatRateShipping] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFlatRateShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishSelectFlatRateShipping
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFlatRateShippingWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFlatRateShippingWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateSelectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: checkFlatRateSelectFlatRateShippingWaitForPageLoad
		$I->comment("Exiting Action Group [selectFlatRateShipping] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] SelectCheckMoneyPaymentMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsSelectCheckMoneyPayment
		$I->conditionalClick("#p_method_checkmo", "#p_method_checkmo", true); // stepKey: checkCheckMoneyOptionSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: checkCheckMoneyOptionSelectCheckMoneyPaymentWaitForPageLoad
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] SelectCheckMoneyPaymentMethodActionGroup");
		$I->comment("Submit Order and verify information");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
	}
}
