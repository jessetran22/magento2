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
 * @Title("MAGETWO-97228: Product quantity return after order cancel")
 * @Description("Check Product quantity return after order cancel<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCheckProductQtyAfterOrderCancellingTest.xml<br>")
 * @TestCaseId("MAGETWO-97228")
 * @group ConfigurableProduct
 */
class AdminCheckProductQtyAfterOrderCancellingTestCest
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
		$I->createEntity("createConfigProduct", "hook", "defaultSimpleProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createGuestCart", "hook", "GuestCart", [], []); // stepKey: createGuestCart
		$I->createEntity("addCartItem", "hook", "FourCartItems", ["createGuestCart", "createConfigProduct"], []); // stepKey: addCartItem
		$I->createEntity("addGuestOrderAddress", "hook", "GuestAddressInformation", ["createGuestCart"], []); // stepKey: addGuestOrderAddress
		$I->updateEntity("createGuestCart", "hook", "GuestOrderPaymentMethod",["createGuestCart"]); // stepKey: sendGuestPaymentInformation
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Cancel order"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckProductQtyAfterOrderCancellingTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $I->retrieveEntityField('createGuestCart', 'return', 'test')); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->comment("Entering Action Group [openOrder] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadOpenOrder
		$I->comment("Exiting Action Group [openOrder] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Entering Action Group [createPartialInvoice] AdminInvoiceWithUpdatedProductQtyActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceCreatePartialInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceCreatePartialInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoicePageCreatePartialInvoice
		$I->fillField(".order-invoice-tables .col-qty-invoice .qty-input", "1"); // stepKey: fillQtyFieldCreatePartialInvoice
		$I->click(".order-invoice-tables tfoot button[data-ui-id='order-items-update-button']"); // stepKey: clickUpdateQuantityButtonCreatePartialInvoice
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshedCreatePartialInvoice
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: submitInvoiceCreatePartialInvoice
		$I->waitForPageLoad(60); // stepKey: submitInvoiceCreatePartialInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadPageCreatePartialInvoice
		$I->see("The invoice has been created."); // stepKey: seeMessageCreatePartialInvoice
		$I->comment("Exiting Action Group [createPartialInvoice] AdminInvoiceWithUpdatedProductQtyActionGroup");
		$I->comment("Entering Action Group [createShipment] AdminCreateShipmentFromOrderPage");
		$I->click("#order_ship"); // stepKey: clickShipButtonCreateShipment
		$I->waitForPageLoad(30); // stepKey: clickShipButtonCreateShipmentWaitForPageLoad
		$I->click("#tracking_numbers_table tfoot [data-ui-id='shipment-tracking-add-button']"); // stepKey: clickAddTrackingNumberCreateShipment
		$I->fillField("#tracking_numbers_table tr:nth-of-type(1) .col-title input", ""); // stepKey: fillTitleCreateShipment
		$I->fillField("#tracking_numbers_table tr:nth-of-type(1) .col-number input", "111"); // stepKey: fillNumberCreateShipment
		$I->fillField(".order-shipment-table tbody:nth-of-type(1) .col-qty input.qty-item", "1"); // stepKey: fillQtyCreateShipment
		$I->fillField("#shipment_comment_text", ""); // stepKey: fillCommentCreateShipment
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitButtonCreateShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitButtonCreateShipmentWaitForPageLoad
		$I->see("The shipment has been created."); // stepKey: seeSuccessMessageCreateShipment
		$I->comment("Exiting Action Group [createShipment] AdminCreateShipmentFromOrderPage");
		$I->comment("Entering Action Group [cancelOrder] CancelPendingOrderActionGroup");
		$I->click("#order-view-cancel-button"); // stepKey: clickCancelOrderCancelOrder
		$I->waitForPageLoad(30); // stepKey: clickCancelOrderCancelOrderWaitForPageLoad
		$I->waitForElement("aside.confirm .modal-content", 30); // stepKey: waitForCancelConfirmationCancelOrder
		$I->see("Are you sure you want to cancel this order?", "aside.confirm .modal-content"); // stepKey: seeConfirmationMessageCancelOrder
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmOrderCancelCancelOrder
		$I->waitForPageLoad(60); // stepKey: confirmOrderCancelCancelOrderWaitForPageLoad
		$I->see("You canceled the order.", "#messages div.message-success"); // stepKey: seeCancelSuccessMessageCancelOrder
		$I->see("Complete", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusCanceledCancelOrder
		$I->comment("Exiting Action Group [cancelOrder] CancelPendingOrderActionGroup");
		$I->see("Canceled 3", ".edit-order-table tr:nth-of-type(1) .col-ordered-qty .qty-table"); // stepKey: seeCanceledQty
		$I->comment("Entering Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage
		$I->comment("Exiting Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku
		$I->comment("Exiting Action Group [filterProductGridBySku] FilterProductGridBySku2ActionGroup");
		$I->comment("Entering Action Group [assertProductDataInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("99", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Quantity']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueAssertProductDataInGrid
		$I->comment("Exiting Action Group [assertProductDataInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
	}
}
