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
 * @Title("MAGETWO-94135: Out of stock associated products to configurable are not full page cache cleaned")
 * @Description("After last configurable product was ordered it becomes out of stock<h3>Test files</h3>app/code/Magento/CatalogInventory/Test/Mftf/Test/AssociatedProductToConfigurableOutOfStockTest.xml<br>")
 * @TestCaseId("MAGETWO-94135")
 * @group CatalogInventory
 */
class AssociatedProductToConfigurableOutOfStockTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("simplecategory", "hook", "SimpleSubCategory", [], []); // stepKey: simplecategory
		$I->comment("Create configurable product with two options");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["simplecategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create child product with single quantity");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleSingleQty", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Create customer");
		$createSimpleUsCustomerFields['group_id'] = "1";
		$I->createEntity("createSimpleUsCustomer", "hook", "Simple_US_Customer", [], $createSimpleUsCustomerFields); // stepKey: createSimpleUsCustomer
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("simplecategory", "hook"); // stepKey: deleteSimpleCategory
		$I->deleteEntity("createSimpleUsCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"CatalogInventory"})
	 * @Stories({"Add/remove images and videos for all product types and category"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AssociatedProductToConfigurableOutOfStockTest(AcceptanceTester $I)
	{
		$I->comment("Login as a customer");
		$I->comment("Entering Action Group [signUpNewUser] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedSignUpNewUser
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsSignUpNewUser
		$I->fillField("#email", $I->retrieveEntityField('createSimpleUsCustomer', 'email', 'test')); // stepKey: fillEmailSignUpNewUser
		$I->fillField("#pass", $I->retrieveEntityField('createSimpleUsCustomer', 'password', 'test')); // stepKey: fillPasswordSignUpNewUser
		$I->click("#send2"); // stepKey: clickSignInAccountButtonSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonSignUpNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInSignUpNewUser
		$I->comment("Exiting Action Group [signUpNewUser] LoginToStorefrontActionGroup");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . "2.html"); // stepKey: goToConfigProductPage
		$I->comment("Go to configurable product page");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Order product with single quantity");
		$I->selectOption("#attribute" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_id', 'test'), $I->retrieveEntityField('createConfigProductAttributeOption1', 'option[store_labels][1][label]', 'test')); // stepKey: configProductFillOption
		$I->click("#product-addtocart-button"); // stepKey: addSimpleProductToCart
		$I->waitForPageLoad(60); // stepKey: addSimpleProductToCartWaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->comment("Entering Action Group [goToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage
		$I->comment("Exiting Action Group [goToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Entering Action Group [StorefrontSignOutActionGroup] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonStorefrontSignOutActionGroup
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutStorefrontSignOutActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStorefrontSignOutActionGroup
		$I->see("You are signed out"); // stepKey: signOutStorefrontSignOutActionGroup
		$I->comment("Exiting Action Group [StorefrontSignOutActionGroup] StorefrontSignOutActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Reset admin order filter");
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->fillField("#fulltext", $grabOrderNumber); // stepKey: searchOrderNum
		$I->click(".//*[@id='container']/div/div[2]/div[1]/div[2]/button"); // stepKey: submitSearch
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask4
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Entering Action Group [clickInvoice] AdminClickInvoiceButtonOrderViewActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionClickInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionClickInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageClickInvoice
		$I->comment("Exiting Action Group [clickInvoice] AdminClickInvoiceButtonOrderViewActionGroup");
		$I->comment("Entering Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceClickSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceClickSubmitInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoiceToBeCreatedClickSubmitInvoice
		$I->comment("Exiting Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->see("The invoice has been created.", "div.message-success"); // stepKey: seeSuccessMessage
		$I->click("#order_ship"); // stepKey: clickShip
		$I->waitForPageLoad(30); // stepKey: clickShipWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForShipLoadingMask
		$I->click("button.action-default.save.submit-button"); // stepKey: submitShipment
		$I->waitForPageLoad(60); // stepKey: submitShipmentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitShipmentCreated
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$runCron = $I->magentoCLI("cron:run --group='index'", 60); // stepKey: runCron
		$I->comment($runCron);
		$I->comment("Wait till cron job runs for schedule updates");
		$I->wait(60); // stepKey: waitForUpdateStarts
		$I->comment("Assert that product with single quantity is not available for order");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . "2.html"); // stepKey: goToConfigProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->dontSee($I->retrieveEntityField('createConfigProductAttributeOption1', 'option[store_labels][1][label]', 'test'), "#attribute" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_id', 'test')); // stepKey: assertOptionNotAvailable
	}
}
