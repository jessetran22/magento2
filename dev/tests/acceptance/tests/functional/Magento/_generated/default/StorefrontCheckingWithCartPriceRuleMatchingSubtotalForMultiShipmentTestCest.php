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
 * @Title("MC-21738: Checking sub total amount and free shipping is applied with multiple shipment addresses on front end order page")
 * @Description("Cart Price Rules not working and free shipping not applied for Multi shipping<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontCheckingWithCartPriceRuleMatchingSubtotalForMultiShipmentTest.xml<br>")
 * @TestCaseId("MC-21738")
 * @group Multishipment
 * @group SalesRule
 */
class StorefrontCheckingWithCartPriceRuleMatchingSubtotalForMultiShipmentTestCest
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
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product1", "hook", "SimpleProduct", ["category"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "SimpleProduct", ["category"], []); // stepKey: product2
		$I->createEntity("customer", "hook", "Simple_US_Customer_Two_Addresses", [], []); // stepKey: customer
		$I->createEntity("enableFreeShipping", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShipping
		$I->createEntity("enableFlatRateShipping", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRateShipping
		$I->comment("Entering Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
		$enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod
		$I->comment($enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod);
		$I->comment("Exiting Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'hook')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'hook')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
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
	 * @Features({"Multishipping"})
	 * @Stories({"Checking cart price rule for multi shipment with multiple shipment addresses on front end order page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckingWithCartPriceRuleMatchingSubtotalForMultiShipmentTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [createSubtotalCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsWithSubtotalActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateSubtotalCartPriceRuleActionsSection
		$I->click("#add"); // stepKey: clickAddNewRuleCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateSubtotalCartPriceRuleActionsSectionWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateSubtotalCartPriceRuleActionsSection
		$I->fillField("input[name='name']", "Cart Price Rule For Rule Condition" . msq("CartPriceRuleConditionForSubtotalForMultiShipping")); // stepKey: fillRuleNameCreateSubtotalCartPriceRuleActionsSection
		$getSubtotalRuleCreateSubtotalCartPriceRuleActionsSection = $I->grabTextFrom("input[name='name']"); // stepKey: getSubtotalRuleCreateSubtotalCartPriceRuleActionsSection
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateSubtotalCartPriceRuleActionsSection
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateSubtotalCartPriceRuleActionsSection
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateSubtotalCartPriceRuleActionsSectionWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateSubtotalCartPriceRuleActionsSection
		$I->click("div[data-index='conditions']"); // stepKey: openConditionsSectionCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: openConditionsSectionCreateSubtotalCartPriceRuleActionsSectionWaitForPageLoad
		$I->click("//*[@id='conditions__1__children']//span"); // stepKey: addFirstConditionCreateSubtotalCartPriceRuleActionsSection
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Subtotal"); // stepKey: selectCondition1CreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoadCreateSubtotalCartPriceRuleActionsSection
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickToChooseOptionCreateSubtotalCartPriceRuleActionsSection
		$I->selectOption(".rule-param-edit select", "equals or greater than"); // stepKey: setOperatorTypeCreateSubtotalCartPriceRuleActionsSection
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickEllipsisCreateSubtotalCartPriceRuleActionsSection
		$I->fillField("[id='conditions__1--1__value']", "50"); // stepKey: fillSubtotalParameterCreateSubtotalCartPriceRuleActionsSection
		$I->click("//ul[@id = 'conditions__1__children']/li/span[contains(@class, 'rule-param-new-child')]"); // stepKey: clickOnTheAddNewConditionCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickOnTheAddNewConditionCreateSubtotalCartPriceRuleActionsSectionWaitForPageLoad
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Shipping Method"); // stepKey: selectSecondConditionCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoad2CreateSubtotalCartPriceRuleActionsSection
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickEllipsis2CreateSubtotalCartPriceRuleActionsSection
		$I->selectOption("[id='conditions__1--2__value']", "[flatrate] Fixed"); // stepKey: selectShippingMethodCreateSubtotalCartPriceRuleActionsSection
		$I->click("//div[@class='admin__actions-switch']/input[@name='apply_to_shipping']/../label"); // stepKey: clickApplyToShippingCreateSubtotalCartPriceRuleActionsSection
		$I->click("//div[@class='admin__actions-switch']/input[@name='stop_rules_processing']/../label"); // stepKey: clickDiscardSubsequentRulesCreateSubtotalCartPriceRuleActionsSection
		$I->selectOption("//select[@name='simple_free_shipping']", "For matching items only"); // stepKey: selectForMatchingItemsOnlyCreateSubtotalCartPriceRuleActionsSection
		$I->click("#save"); // stepKey: clickSaveButtonCreateSubtotalCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateSubtotalCartPriceRuleActionsSectionWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateSubtotalCartPriceRuleActionsSection
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateSubtotalCartPriceRuleActionsSection
		$I->comment("Expand the conditions section");
		$I->comment("Exiting Action Group [createSubtotalCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsWithSubtotalActionGroup");
		$I->amOnPage($I->retrieveEntityField('product1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProduct1
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct1] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct1
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct1
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct1
		$I->see("You added " . $I->retrieveEntityField('product1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct1
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct1] AddToCartFromStorefrontProductPageActionGroup");
		$I->amOnPage($I->retrieveEntityField('product2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProduct2
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct2] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct2
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct2
		$I->see("You added " . $I->retrieveEntityField('product2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct2] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleAddresses] CheckingWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultipleAddresses
		$firstShippingAddressValueCheckoutWithMultipleAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(1) .col.address select option:nth-of-type(1)"); // stepKey: firstShippingAddressValueCheckoutWithMultipleAddresses
		$I->selectOption("//tr[position()=1]//td[@data-th='Send To']//select", $firstShippingAddressValueCheckoutWithMultipleAddresses); // stepKey: selectFirstShippingMethodCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingAddressesCheckoutWithMultipleAddresses
		$secondShippingAddressValueCheckoutWithMultipleAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(2) .col.address select option:nth-of-type(2)"); // stepKey: secondShippingAddressValueCheckoutWithMultipleAddresses
		$I->selectOption("//tr[position()=2]//td[@data-th='Send To']//select", $secondShippingAddressValueCheckoutWithMultipleAddresses); // stepKey: selectSecondShippingMethodCheckoutWithMultipleAddresses
		$I->click("//button[@class='action update']"); // stepKey: clickOnUpdateAddressCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingInformationCheckoutWithMultipleAddresses
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [checkoutWithMultipleAddresses] CheckingWithMultipleAddressesActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->selectOption("//div[@class='block block-shipping'][position()=1]//dd[position()=1]//input[@class='radio']", "Fixed"); // stepKey: selectShippingMethod1CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod1CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingMethodCheckoutWithMultipleShipping
		$I->selectOption("//div[@class='block block-shipping'][position()=2]//dd[position()=2]//input[@class='radio']", "Free"); // stepKey: selectShippingMethod2CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod2CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRadioOptionsCheckoutWithMultipleShipping
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationCheckoutWithMultipleShipping
		$I->comment("Exiting Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->comment("Entering Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadCheckoutWithPaymentMethod
		$I->click("#payment-continue"); // stepKey: goToReviewOrderCheckoutWithPaymentMethod
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderCheckoutWithPaymentMethodWaitForPageLoad
		$I->comment("Exiting Action Group [checkoutWithPaymentMethod] SelectBillingInfoActionGroup");
		$I->comment("Entering Action Group [reviewOrderForMultiShipment] ReviewOrderForMultiShipmentActionGroup");
		$I->comment("Check First Shipping Method Price");
		$firstShippingMethodBasePriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: firstShippingMethodBasePriceReviewOrderForMultiShipment
		$firstShippingMethodSubtotalPriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: firstShippingMethodSubtotalPriceReviewOrderForMultiShipment
		$I->assertEquals("$firstShippingMethodSubtotalPriceReviewOrderForMultiShipment", "$firstShippingMethodBasePriceReviewOrderForMultiShipment"); // stepKey: assertShippingMethodPriceReviewOrderForMultiShipment
		$I->comment("Check Second Shipping Method Price");
		$secondShippingMethodBasePriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=2]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: secondShippingMethodBasePriceReviewOrderForMultiShipment
		$secondShippingMethodSubtotalPriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=2]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: secondShippingMethodSubtotalPriceReviewOrderForMultiShipment
		$I->assertEquals("$secondShippingMethodSubtotalPriceReviewOrderForMultiShipment", "$secondShippingMethodBasePriceReviewOrderForMultiShipment"); // stepKey: assertSecondShippingMethodPriceReviewOrderForMultiShipment
		$I->comment("Exiting Action Group [reviewOrderForMultiShipment] ReviewOrderForMultiShipmentActionGroup");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderActionGroup");
		$I->comment("Entering Action Group [deleteCreatedCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteCreatedCartPriceRule
		$I->fillField("input[name='name']", $getSubtotalRuleCreateSubtotalCartPriceRuleActionsSection); // stepKey: filterByNameDeleteCreatedCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteCreatedCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteCreatedCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCreatedCartPriceRule] DeleteCartPriceRuleByName");
	}
}
