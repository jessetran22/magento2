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
 * @Title("[NO TESTCASEID]: Create a product and orders with set 'Move Js code to the bottom' to 'Yes'.")
 * @Description("Create a product and orders with a set 'Move JS code to the bottom of the page' to 'Yes' for registered customers and guests.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontCreateOrdersWithMoveJSCodeBottomTest.xml<br>")
 */
class StorefrontCreateOrdersWithMoveJSCodeBottomTestCest
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
		$moveJsCodeBottomEnable = $I->magentoCLI("config:set dev/js/move_script_to_bottom 1", 60); // stepKey: moveJsCodeBottomEnable
		$I->comment($moveJsCodeBottomEnable);
		$cleanInvalidatedCaches = $I->magentoCLI("cache:clean config full_page", 60); // stepKey: cleanInvalidatedCaches
		$I->comment($cleanInvalidatedCaches);
		$I->comment("Entering Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogInAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogInAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogInAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogInAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogInAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogInAsAdmin
		$I->comment("Exiting Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [createCategory] CreateCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateCategory
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateCategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateCategory
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: enterCategoryNameCreateCategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateCategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateCategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplecategory" . msq("_defaultCategory")); // stepKey: enterURLKeyCreateCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateCategory
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeNewCategoryPageTitleCreateCategory
		$I->seeElement("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: seeCategoryInTreeCreateCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createCategory] CreateCategoryActionGroup");
		$I->comment("Entering Action Group [createSimpleProduct] AdminCreateSimpleProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateSimpleProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddSimpleProductCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddSimpleProductCreateSimpleProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameCreateSimpleProduct
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUCreateSimpleProduct
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceCreateSimpleProduct
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityCreateSimpleProduct
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", ["simpleCategory" . msq("_defaultCategory")]); // stepKey: searchAndSelectCategoryCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryCreateSimpleProductWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: openSeoSectionCreateSimpleProductWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyCreateSimpleProduct
		$I->click("#save-button"); // stepKey: saveProductCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: saveProductCreateSimpleProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessCreateSimpleProduct
		$I->seeInField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: assertFieldNameCreateSimpleProduct
		$I->seeInField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: assertFieldSkuCreateSimpleProduct
		$I->seeInField(".admin__field[data-index=price] input", "123.00"); // stepKey: assertFieldPriceCreateSimpleProduct
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionAssertCreateSimpleProduct
		$I->waitForPageLoad(30); // stepKey: openSeoSectionAssertCreateSimpleProductWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: assertFieldUrlKeyCreateSimpleProduct
		$I->comment("Exiting Action Group [createSimpleProduct] AdminCreateSimpleProductActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [deleteSimpleProduct] DeleteProductActionGroup");
		$I->click("#menu-magento-catalog-catalog"); // stepKey: openCatalogDeleteSimpleProduct
		$I->waitForPageLoad(5); // stepKey: waitForCatalogSubmenuDeleteSimpleProduct
		$I->click("//li[@id='menu-magento-catalog-catalog']//li[@data-ui-id='menu-magento-catalog-catalog-products']"); // stepKey: clickOnProductsDeleteSimpleProduct
		$I->waitForPageLoad(10); // stepKey: waitForProductsPageDeleteSimpleProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSimpleProductWaitForPageLoad
		$I->click("//*[contains(text(),'testProductName" . msq("_defaultProduct") . "')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']"); // stepKey: TickCheckboxDeleteSimpleProduct
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageDeleteSimpleProduct
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: OpenActionsDeleteSimpleProduct
		$I->waitForAjaxLoad(5); // stepKey: waitForDeleteDeleteSimpleProduct
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: ChooseDeleteDeleteSimpleProduct
		$I->waitForPageLoad(10); // stepKey: waitForDeleteItemPopupDeleteSimpleProduct
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOnOkDeleteSimpleProduct
		$I->waitForElementVisible("//*[@class='message message-success success']", 10); // stepKey: waitForSuccessfullyDeletedMessageDeleteSimpleProduct
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearDeleteSimpleProduct
		$I->comment("Exiting Action Group [deleteSimpleProduct] DeleteProductActionGroup");
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
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$moveJsCodeBottomDisable = $I->magentoCLI("config:set dev/js/move_script_to_bottom 0", 60); // stepKey: moveJsCodeBottomDisable
		$I->comment($moveJsCodeBottomDisable);
		$cleanInvalidatedCaches = $I->magentoCLI("cache:clean config full_page", 60); // stepKey: cleanInvalidatedCaches
		$I->comment($cleanInvalidatedCaches);
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
	 * @Stories({"Create a product and orders with set 'Move Js code to the bottom' to 'Yes'."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateOrdersWithMoveJSCodeBottomTest(AcceptanceTester $I)
	{
		$I->comment("Go to Storefront and place order for guest");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added testProductName" . msq("_defaultProduct") . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [guestGoToCheckoutFromCart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutFromCart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutFromCart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutFromCart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutFromCartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutFromCart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutFromCartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutFromCart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [fillNewShippingAddress] GuestCheckoutFillNewShippingAddressActionGroup");
		$I->fillField("input[id*=customer-email]", msq("Simple_Customer_Without_Address") . "John.Doe@example.com"); // stepKey: fillEmailFieldFillNewShippingAddress
		$I->fillField("input[name=firstname]", "John"); // stepKey: fillFirstNameFillNewShippingAddress
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastNameFillNewShippingAddress
		$I->fillField("input[name='street[0]']", "[\"7700 West Parmer Lane\"]"); // stepKey: fillStreetFillNewShippingAddress
		$I->fillField("input[name=city]", "Austin"); // stepKey: fillCityFillNewShippingAddress
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillNewShippingAddress
		$I->fillField("input[name=postcode]", "78729"); // stepKey: fillZipCodeFillNewShippingAddress
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: fillPhoneFillNewShippingAddress
		$I->comment("Exiting Action Group [fillNewShippingAddress] GuestCheckoutFillNewShippingAddressActionGroup");
		$I->comment("Entering Action Group [setShippingMethodFreeShipping] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodFreeShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodFreeShipping
		$I->comment("Exiting Action Group [setShippingMethodFreeShipping] StorefrontSetShippingMethodActionGroup");
		$I->comment("Entering Action Group [goToCheckoutReview] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutReviewWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutReviewWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutReviewWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutReview
		$I->comment("Exiting Action Group [goToCheckoutReview] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [guestPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonGuestPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonGuestPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderGuestPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderGuestPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutGuestPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageGuestPlaceOrder
		$I->comment("Exiting Action Group [guestPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Go to frontend and make a user account and login with it");
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
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
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Entering Action Group [AddNewAddress] StorefrontAddNewCustomerAddressActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: OpenCustomerAddNewAddressAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstNameAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastNameAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'company')]", "Magento"); // stepKey: fillCompanyNameAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillPhoneNumberAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'street')]", "7700 West Parmer Lane"); // stepKey: fillStreetAddressAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'city')]", "Austin"); // stepKey: fillCityAddNewAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'region_id')]", "Texas"); // stepKey: selectStateAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'postcode')]", "78729"); // stepKey: fillZipAddNewAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "United States"); // stepKey: selectCountryAddNewAddress
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressAddNewAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressAddNewAddressWaitForPageLoad
		$I->see("You saved the address."); // stepKey: verifyAddressAddedAddNewAddress
		$I->comment("Exiting Action Group [AddNewAddress] StorefrontAddNewCustomerAddressActionGroup");
		$I->comment("Go to Storefront and place order for customer");
		$I->comment("Entering Action Group [openStorefrontProductPage2] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/testproductname" . msq("_defaultProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage2
		$I->comment("Exiting Action Group [openStorefrontProductPage2] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart2] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart2
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart2
		$I->see("You added testProductName" . msq("_defaultProduct") . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart2
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCart2WaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart2
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart2
		$I->comment("Exiting Action Group [addProductToCart2] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [customerGoToCheckoutFromCart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityCustomerGoToCheckoutFromCart
		$I->wait(5); // stepKey: waitMinicartRenderingCustomerGoToCheckoutFromCart
		$I->click("a.showcart"); // stepKey: clickCartCustomerGoToCheckoutFromCart
		$I->waitForPageLoad(60); // stepKey: clickCartCustomerGoToCheckoutFromCartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutCustomerGoToCheckoutFromCart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutCustomerGoToCheckoutFromCartWaitForPageLoad
		$I->comment("Exiting Action Group [customerGoToCheckoutFromCart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [setShippingMethodFreeShipping2] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodFreeShipping2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodFreeShipping2
		$I->comment("Exiting Action Group [setShippingMethodFreeShipping2] StorefrontSetShippingMethodActionGroup");
		$I->comment("Entering Action Group [goToCheckoutReview2] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutReview2
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutReview2WaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutReview2
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutReview2WaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutReview2
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutReview2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutReview2
		$I->comment("Exiting Action Group [goToCheckoutReview2] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyPayment2] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment2
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment2
		$I->comment("Exiting Action Group [selectCheckMoneyPayment2] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [customerPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutCustomerPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageCustomerPlaceOrder
		$I->comment("Exiting Action Group [customerPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Entering Action Group [singOutCustomer] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSingOutCustomer
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSingOutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSingOutCustomer
		$I->see("You are signed out"); // stepKey: signOutSingOutCustomer
		$I->comment("Exiting Action Group [singOutCustomer] StorefrontSignOutActionGroup");
	}
}
