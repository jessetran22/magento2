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
 * @Title("MC-11059: Check correctness of invoiced items in a Bundle Product")
 * @Description("Check correctness of invoiced items in a Bundle Product<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCorrectnessInvoicedItemInBundleProductTest.xml<br>")
 * @TestCaseId("MC-11059")
 * @group sales
 */
class AdminCorrectnessInvoicedItemInBundleProductTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create category and simple product");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Create bundle product");
		$I->createEntity("createBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createBundleProduct
		$I->createEntity("bundleOption", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: bundleOption
		$createBundleLink1Fields['qty'] = "10";
		$I->createEntity("createBundleLink1", "hook", "ApiBundleLink", ["createBundleProduct", "bundleOption", "createSimpleProduct"], $createBundleLink1Fields); // stepKey: createBundleLink1
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
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
	 * @Stories({"Product invoice"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCorrectnessInvoicedItemInBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Complete Bundle product creation");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createBundleProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
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
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Go to bundle product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToBundleProductPage
		$I->comment("Place order bundle product with 10 options");
		$I->comment("Entering Action Group [addBundleProductToCart] StorefrontAddCategoryBundleProductWithSingleChoiceToCartActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddBundleProductToCart
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddBundleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AddBundleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddBundleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddBundleProductToCart
		$I->comment("Open minicart and change Qty");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageAddBundleProductToCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleAddBundleProductToCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleAddBundleProductToCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartAddBundleProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartAddBundleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2AddBundleProductToCart
		$I->waitForElementVisible("span.counter-number", 30); // stepKey: waitForElementQtyAddBundleProductToCart
		$I->pressKey("//a[text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "']/../..//input[contains(@class,'cart-item-qty')]", \Facebook\WebDriver\WebDriverKeys::BACKSPACE); // stepKey: deleteFiledAddBundleProductToCart
		$I->fillField("//a[text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "']/../..//input[contains(@class,'cart-item-qty')]", "10"); // stepKey: changeQtyAddBundleProductToCart
		$I->conditionalClick("//a[text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "']/../..//span[text()='Update']", "//a[text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "']/../..//span[text()='Update']", true); // stepKey: updateQtyAddBundleProductToCart
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadAddBundleProductToCart
		$I->waitForText("10", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddBundleProductToCart
		$I->comment("Close minicart");
		$I->click("a.showcart"); // stepKey: clickOnMiniCartToCloseAddBundleProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartToCloseAddBundleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3AddBundleProductToCart
		$I->comment("Exiting Action Group [addBundleProductToCart] StorefrontAddCategoryBundleProductWithSingleChoiceToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
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
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShipping
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShipping
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShipping
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShipping
		$I->comment("Exiting Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Entering Action Group [placeOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouPlaceOrder
		$I->comment("Exiting Action Group [placeOrder] CheckoutPlaceOrderActionGroup");
		$I->comment("Go to order page submit invoice");
		$grabOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabOrderNumber
		$I->comment("Entering Action Group [onOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOnOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOnOrdersPage
		$I->comment("Exiting Action Group [onOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Entering Action Group [goToInvoiceIntoOrderPage] GoToInvoiceIntoOrderActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionGoToInvoiceIntoOrderPage
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionGoToInvoiceIntoOrderPageWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeOrderInvoiceUrlGoToInvoiceIntoOrderPage
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seePageNameNewInvoicePageGoToInvoiceIntoOrderPage
		$I->comment("Exiting Action Group [goToInvoiceIntoOrderPage] GoToInvoiceIntoOrderActionGroup");
		$I->fillField(".order-invoice-tables .col-qty-invoice .qty-input", "5"); // stepKey: ChangeQtyToInvoice
		$I->click(".order-invoice-tables tfoot button[data-ui-id='order-items-update-button']"); // stepKey: updateQuantity
		$I->waitForPageLoad(30); // stepKey: waitPageToBeLoaded
		$I->comment("Entering Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessSubmitInvoice
		$grabOrderIdSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceSubmitInvoice
		$I->comment("Exiting Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Verify invoiced items qty in ship tab");
		$I->comment("Entering Action Group [goToShipment] GoToShipmentIntoOrderActionGroup");
		$I->click("#order_ship"); // stepKey: clickShipActionGoToShipment
		$I->waitForPageLoad(30); // stepKey: clickShipActionGoToShipmentWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/order_shipment/new/order_id/"); // stepKey: seeOrderShipmentUrlGoToShipment
		$I->see("New Shipment", ".page-header h1.page-title"); // stepKey: seePageNameNewInvoicePageGoToShipment
		$I->comment("Exiting Action Group [goToShipment] GoToShipmentIntoOrderActionGroup");
		$grabInvoicedItemQty = $I->grabTextFrom("(//*[@class='col-ordered-qty']//th[contains(text(), 'Invoiced')]/following-sibling::td)[1]"); // stepKey: grabInvoicedItemQty
		$I->assertEquals("5", $grabInvoicedItemQty); // stepKey: assertInvoicedItemsQty
	}
}
