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
 * @Title("MC-35198: My Account Downloadable Product Link after Partially Refunded")
 * @Description("Verify that Downloadable product is not available in My Download Products tab after it has been partially refunded.<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/StorefrontAccountDownloadableProductLinkAfterPartialRefundTest.xml<br>")
 * @TestCaseId("MC-35198")
 * @group Downloadable
 */
class StorefrontAccountDownloadableProductLinkAfterPartialRefundTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink1", "hook", "downloadableLink1", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink1
		$I->comment("Adding the comment to replace 'indexer:reindex' command for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [signIn] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageSignIn
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedSignIn
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsSignIn
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillEmailSignIn
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'hook')); // stepKey: fillPasswordSignIn
		$I->click("#send2"); // stepKey: clickSignInAccountButtonSignIn
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonSignInWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInSignIn
		$I->comment("Exiting Action Group [signIn] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteDownloadableProduct
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$I->comment("Adding the comment to replace 'indexer:reindex' command for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Features({"Downloadable"})
	 * @Stories({"Customer Account Downloadable Products Link"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAccountDownloadableProductLinkAfterPartialRefundTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [addSimpleProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageOpenAddSimpleProductToCart
		$I->fillField("#qty", "1"); // stepKey: fillQtyAddSimpleProductToCart
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddSimpleProductToCart
		$I->waitForElementVisible(".messages .message-success", 30); // stepKey: waitForSuccessMessageAddSimpleProductToCart
		$I->comment("Exiting Action Group [addSimpleProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: OpenStoreFrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Entering Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToTheCart
		$I->see("You added " . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToTheCart
		$I->comment("Exiting Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartFromMinicart
		$I->comment("Exiting Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForProceedToCheckout action for preserving Backward Compatibility");
		$I->waitForElementVisible("//div[text()='172, Westminster Bridge Rd']/button[@class='action action-select-shipping-item']", 30); // stepKey: waitForShipHereVisible
		$I->waitForPageLoad(30); // stepKey: waitForShipHereVisibleWaitForPageLoad
		$I->click("//div[text()='172, Westminster Bridge Rd']/button[@class='action action-select-shipping-item']"); // stepKey: clickShipHere
		$I->waitForPageLoad(30); // stepKey: clickShipHereWaitForPageLoad
		$I->comment("Entering Action Group [clickNext] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedClickNext
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->checkOption("#billing-address-same-as-shipping-checkmo"); // stepKey: selectPaymentSolution
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoaded
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderButton
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderButtonWaitForPageLoad
		$I->seeElement("div.checkout-success"); // stepKey: orderIsSuccessfullyPlaced
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: onOrdersPage
		$I->comment("Entering Action Group [searchOrder] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchOrder
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", "{{$grabOrderNumber}}"); // stepKey: fillKeywordSearchFieldSearchOrder
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchOrder
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchOrderWaitForPageLoad
		$I->comment("Exiting Action Group [searchOrder] SearchAdminDataGridByKeywordActionGroup");
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Entering Action Group [createCreditMemo] AdminCreateInvoiceActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceCreateCreditMemo
		$I->waitForPageLoad(30); // stepKey: clickInvoiceCreateCreditMemoWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoicePageCreateCreditMemo
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: submitInvoiceCreateCreditMemo
		$I->waitForPageLoad(60); // stepKey: submitInvoiceCreateCreditMemoWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadPageCreateCreditMemo
		$I->see("The invoice has been created."); // stepKey: seeMessageCreateCreditMemo
		$I->comment("Exiting Action Group [createCreditMemo] AdminCreateInvoiceActionGroup");
		$I->comment("Entering Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrder
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrder
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterOpenOrder
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrder
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrder
		$I->comment("Exiting Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->comment("Entering Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundActionGroup");
		$I->comment("Click 'Credit Memo' button");
		$I->click("#order_creditmemo"); // stepKey: clickCreateCreditMemoFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickCreateCreditMemoFillCreditMemoRefundWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_creditmemo/new/order_id/"); // stepKey: seeNewCreditMemoPageFillCreditMemoRefund
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoInPageTitleFillCreditMemoRefund
		$I->comment("Fill data from dataset: refund");
		$I->scrollTo("#creditmemo_item_container span.title"); // stepKey: scrollToItemsToRefundFillCreditMemoRefund
		$I->fillField(".order-creditmemo-tables tbody:nth-of-type(1) .col-refund .qty-input", "0"); // stepKey: fillQtyToRefundFillCreditMemoRefund
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForActivateButtonFillCreditMemoRefund
		$I->conditionalClick(".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button']", ".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button'].disabled", false); // stepKey: clickUpdateButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateButtonFillCreditMemoRefundWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForUpdateFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[shipping_amount]']", "0"); // stepKey: fillShippingFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_positive]']", "0"); // stepKey: fillAdjustmentRefundFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_negative]']", "0"); // stepKey: fillAdjustmentFeeFillCreditMemoRefund
		$I->waitForElementVisible(".update-totals-button", 30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefundWaitForPageLoad
		$I->click(".update-totals-button"); // stepKey: clickUpdateTotalsFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateTotalsFillCreditMemoRefundWaitForPageLoad
		$I->checkOption(".order-totals-actions #send_email"); // stepKey: checkSendEmailCopyFillCreditMemoRefund
		$I->comment("Exiting Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundActionGroup");
		$I->comment("Entering Action Group [clickRefundOffline] AdminClickRefundOfflineOnNewMemoPageActionGroup");
		$I->click(".order-totals-actions button[data-ui-id='order-items-submit-button']"); // stepKey: clickRefundOfflineClickRefundOffline
		$I->waitForPageLoad(60); // stepKey: clickRefundOfflineClickRefundOfflineWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccesMessageClickRefundOffline
		$I->see("You created the credit memo.", "#messages div.message-success"); // stepKey: seeSuccessMessageClickRefundOffline
		$I->comment("Exiting Action Group [clickRefundOffline] AdminClickRefundOfflineOnNewMemoPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [dontSeeStorefrontMyAccountDownloadableProductsLink] StorefrontNotAssertDownloadableProductLinkInCustomerAccountActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageDontSeeStorefrontMyAccountDownloadableProductsLink
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Downloadable Products']"); // stepKey: clickDownloadableProductsDontSeeStorefrontMyAccountDownloadableProductsLink
		$I->waitForPageLoad(60); // stepKey: clickDownloadableProductsDontSeeStorefrontMyAccountDownloadableProductsLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDownloadableProductsPageLoadDontSeeStorefrontMyAccountDownloadableProductsLink
		$I->seeElement("//table[@id='my-downloadable-products-table']//strong[contains(@class, 'product-name') and normalize-space(.)='" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "']"); // stepKey: seeStorefrontDownloadableProductsProductNameDontSeeStorefrontMyAccountDownloadableProductsLink
		$I->dontSeeElement("//table[@id='my-downloadable-products-table']//a[contains(@class, 'download')]"); // stepKey: dontSeeStorefrontMyDownloadableProductsLinkDontSeeStorefrontMyAccountDownloadableProductsLink
		$I->comment("Exiting Action Group [dontSeeStorefrontMyAccountDownloadableProductsLink] StorefrontNotAssertDownloadableProductLinkInCustomerAccountActionGroup");
	}
}
