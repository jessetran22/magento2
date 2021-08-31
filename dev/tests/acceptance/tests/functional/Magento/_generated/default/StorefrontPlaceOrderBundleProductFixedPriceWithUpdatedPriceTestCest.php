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
 * @Title("MC-40744: Order details with bundle product fixed price should show the correct price for bundle items")
 * @Description("Order details with bundle product fixed price should show the correct price for bundle items<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontPlaceOrderBundleProductFixedPriceWithUpdatedPriceTest.xml<br>")
 * @TestCaseId("MC-40744")
 * @group bundle
 * @group catalog
 */
class StorefrontPlaceOrderBundleProductFixedPriceWithUpdatedPriceTestCest
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
		$I->createEntity("createCustomer", "hook", "CustomerEntityOne", [], []); // stepKey: createCustomer
		$I->createEntity("createFirstProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondProduct
		$createFixedBundleProductFields['price'] = "11.00";
		$I->createEntity("createFixedBundleProduct", "hook", "ApiFixedBundleProduct", [], $createFixedBundleProductFields); // stepKey: createFixedBundleProduct
		$createFirstBundleOptionFields['position'] = "1";
		$I->createEntity("createFirstBundleOption", "hook", "RadioButtonsOption", ["createFixedBundleProduct"], $createFirstBundleOptionFields); // stepKey: createFirstBundleOption
		$createSecondBundleOptionFields['position'] = "2";
		$I->createEntity("createSecondBundleOption", "hook", "RadioButtonsOption", ["createFixedBundleProduct"], $createSecondBundleOptionFields); // stepKey: createSecondBundleOption
		$firstLinkOptionToFixedProductFields['price_type'] = "0";
		$firstLinkOptionToFixedProductFields['price'] = "7.00";
		$I->createEntity("firstLinkOptionToFixedProduct", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createFirstBundleOption", "createFirstProduct"], $firstLinkOptionToFixedProductFields); // stepKey: firstLinkOptionToFixedProduct
		$secondLinkOptionToFixedProductFields['price_type'] = "0";
		$secondLinkOptionToFixedProductFields['price'] = "5.00";
		$I->createEntity("secondLinkOptionToFixedProduct", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createSecondBundleOption", "createSecondProduct"], $secondLinkOptionToFixedProductFields); // stepKey: secondLinkOptionToFixedProduct
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFixedBundleProduct', 'id', 'hook')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteSimpleProductForBundleItem
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteVirtualProductForBundleItem
		$I->deleteEntity("createFixedBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [clearProductsGridFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductsGridFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] AdminClearFiltersActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForClearProductsGridFilters
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
	 * @Features({"Bundle"})
	 * @Stories({"Placing order with bundle product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPlaceOrderBundleProductFixedPriceWithUpdatedPriceTest(AcceptanceTester $I)
	{
		$I->comment("Login customer on storefront");
		$I->comment("Entering Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginCustomer
		$I->comment("Exiting Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open Product Page");
		$I->comment("Entering Action Group [openBundleProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createFixedBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenBundleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenBundleProductPage
		$I->comment("Exiting Action Group [openBundleProductPage] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Add bundle to cart");
		$I->comment("Entering Action Group [clickAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddToCart
		$I->comment("Exiting Action Group [clickAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Open bundle product in admin");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFixedBundleProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Change price of the first option");
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_price_value]']", "9"); // stepKey: fillBundleOption1Price
		$I->comment("Save the bundle product");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Open Product Page");
		$I->comment("Entering Action Group [openBundleProductPage2] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createFixedBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenBundleProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenBundleProductPage2
		$I->comment("Exiting Action Group [openBundleProductPage2] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Add bundle to cart");
		$I->comment("Entering Action Group [clickAddToCart2] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickAddToCart2
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickAddToCart2WaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickAddToCart2
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickAddToCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddToCart2
		$I->comment("Exiting Action Group [clickAddToCart2] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart2] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart2
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart2
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart2
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart2
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart2] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Verify bundle product details");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->see($I->retrieveEntityField('createFirstBundleOption', 'title', 'test'), "dl.item-options dt:nth-of-type(1)"); // stepKey: seeOptionLabelInShoppingCart
		$I->see("1 x " . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . " $9.00", "dl.item-options dd:nth-of-type(1)"); // stepKey: seeOptionValueInShoppingCart
		$I->see($I->retrieveEntityField('createSecondBundleOption', 'title', 'test'), "dl.item-options dt:nth-of-type(2)"); // stepKey: seeOption2LabelInShoppingCart
		$I->see("1 x " . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . " $5.00", "dl.item-options dd:nth-of-type(2)"); // stepKey: seeOption2ValueInShoppingCart
		$I->comment("Verify total");
		$grabShoppingCartTotal = $I->grabTextFrom("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: grabShoppingCartTotal
		$I->assertEquals("$60.00", $grabShoppingCartTotal); // stepKey: verifyGrandTotalOnShoppingCartPage
		$I->comment("Navigate to checkout");
		$I->comment("Entering Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOpenCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOpenCheckoutPage
		$I->comment("Exiting Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->comment("Click next button to open payment section");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextWaitForPageLoad
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Click place order");
		$I->comment("Entering Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Navigate to order details page in custom account");
		$I->amOnPage("sales/order/view/order_id/{$grabOrderNumber}"); // stepKey: amOnOrderPage
		$I->comment("Verify bundle order items details");
		$I->see($I->retrieveEntityField('createFirstBundleOption', 'title', 'test'), ".table-order-items tr:nth-of-type(2) td.label"); // stepKey: seeOptionLabelInCustomerOrderItems
		$I->see("1 x " . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . " $9.00", ".table-order-items tr:nth-of-type(3) td.value"); // stepKey: seeOptionValueInCustomerOrderItems
		$I->see($I->retrieveEntityField('createSecondBundleOption', 'title', 'test'), ".table-order-items tr:nth-of-type(4) td.label"); // stepKey: seeOption2LabelInCustomerOrderItems
		$I->see("1 x " . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . " $5.00", ".table-order-items tr:nth-of-type(5) td.value"); // stepKey: seeOption2ValueInCustomerOrderItems
		$I->comment("Navigate to order details page on admin");
		$I->comment("Entering Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterFilterOrdersGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrdersGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridById
		$I->comment("Exiting Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->comment("Verify bundle order items details");
		$I->see($I->retrieveEntityField('createFirstBundleOption', 'title', 'test'), ".edit-order-table tr:nth-of-type(2) .col-product .option-label"); // stepKey: seeOptionLabelInAdminOrderItems
		$I->see("1 x " . $I->retrieveEntityField('createFirstProduct', 'name', 'test'), ".edit-order-table tr:nth-of-type(3) .col-product .option-value"); // stepKey: seeOptionValueInAdminOrderItems
		$I->see("$9.00", ".edit-order-table tr:nth-of-type(3) .col-product .option-value .price"); // stepKey: seeOptionPriceInAdminOrderItems
		$I->see($I->retrieveEntityField('createSecondBundleOption', 'title', 'test'), ".edit-order-table tr:nth-of-type(4) .col-product .option-label"); // stepKey: seeOption2LabelInAdminOrderItems
		$I->see("1 x " . $I->retrieveEntityField('createSecondProduct', 'name', 'test'), ".edit-order-table tr:nth-of-type(5) .col-product .option-value"); // stepKey: seeOption2ValueInAdminOrderItems
		$I->see("$5.00", ".edit-order-table tr:nth-of-type(5) .col-product .option-value .price"); // stepKey: seeOption2PriceInAdminOrderItems
		$I->comment("Verify total");
		$grabAdminOrderTotal = $I->grabTextFrom(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: grabAdminOrderTotal
		$I->assertEquals("$60.00", $grabAdminOrderTotal); // stepKey: verifyGrandTotalOnAdminOrderPage
	}
}
