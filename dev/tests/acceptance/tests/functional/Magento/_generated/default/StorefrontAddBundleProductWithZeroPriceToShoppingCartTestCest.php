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
 * @Title("MAGETWO-95167: Add Bundle product with zero price to shopping cart")
 * @Description("Add Bundle product with zero price to shopping cart<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontAddBundleProductWithZeroPriceToShoppingCartTest.xml<br>")
 * @TestCaseId("MAGETWO-95167")
 * @group bundle
 */
class StorefrontAddBundleProductWithZeroPriceToShoppingCartTestCest
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
		$I->comment("Enable freeShipping");
		$I->createEntity("enableFreeShipping", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShipping
		$I->comment("Create category");
		$I->createEntity("createSubCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSubCategory
		$I->comment("Create simple with zero price product");
		$apiSimpleFields['price'] = "0";
		$I->createEntity("apiSimple", "hook", "ApiProductWithDescription", [], $apiSimpleFields); // stepKey: apiSimple
		$I->comment("Create Bundle product");
		$I->createEntity("apiBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: apiBundleProduct
		$I->comment("Create Attribute");
		$I->createEntity("bundleOption", "hook", "DropDownBundleOption", ["apiBundleProduct"], []); // stepKey: bundleOption
		$I->createEntity("createBundleLink", "hook", "ApiBundleLink", ["apiBundleProduct", "bundleOption", "apiSimple"], []); // stepKey: createBundleLink
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
		$I->deleteEntity("apiSimple", "hook"); // stepKey: deleteSimple
		$I->deleteEntity("apiBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createSubCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearFilters
		$I->comment("Exiting Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
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
	 * @Features({"Bundle"})
	 * @Stories({"Add Bundle product with zero price to shopping cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddBundleProductWithZeroPriceToShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Open category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSubCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->comment("Add bundle product to cart");
		$I->comment("Entering Action Group [addBundleProductToCart] StorefrontAddBundleProductFromCategoryToCartActionGroup");
		$I->moveMouseOver("//main//li//a[contains(text(), '" . $I->retrieveEntityField('apiBundleProduct', 'name', 'test') . "')]"); // stepKey: moveMouseOverProductAddBundleProductToCart
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('apiBundleProduct', 'name', 'test') . "')]"); // stepKey: openProductPageAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductPageLoadAddBundleProductToCart
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCartAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartAddBundleProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCartAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartAddBundleProductToCartWaitForPageLoad
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitProductCountAddBundleProductToCart
		$I->see("You added " . $I->retrieveEntityField('apiBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeSuccessMessageAddBundleProductToCart
		$I->comment("Exiting Action Group [addBundleProductToCart] StorefrontAddBundleProductFromCategoryToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Place order");
		$I->comment("Entering Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShipping
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShipping
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShipping
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShipping
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShipping
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShipping
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShipping
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShipping
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShipping
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShipping
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShipping
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShipping
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShipping
		$I->comment("Exiting Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Entering Action Group [checkoutPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCheckoutPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCheckoutPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageCheckoutPlaceOrder
		$I->comment("Exiting Action Group [checkoutPlaceOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabOrderNumber
		$I->comment("Check subtotal in created order");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [filterOrderById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterFilterOrderById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderById
		$I->comment("Exiting Action Group [filterOrderById] FilterOrderGridByIdActionGroup");
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->scrollTo(".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: scrollToOrderTotalSection
		$I->see("$0.00", ".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: checkSubtotal
	}
}
