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
 * @Title("MAGETWO-93109: Customer Checkout with multiple addresses and tax rates")
 * @Description("Should be able to place an order as a customer with multiple addresses and tax rates.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerCheckoutTest/StorefrontCustomerCheckoutTestWithMultipleAddressesAndTaxRatesTest.xml<br>")
 * @TestCaseId("MAGETWO-93109")
 * @group checkout
 */
class StorefrontCustomerCheckoutTestWithMultipleAddressesAndTaxRatesTestCest
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
		$I->createEntity("simplecategory", "hook", "SimpleSubCategory", [], []); // stepKey: simplecategory
		$I->createEntity("simpleproduct1", "hook", "SimpleProduct", ["simplecategory"], []); // stepKey: simpleproduct1
		$I->createEntity("multiple_address_customer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: multiple_address_customer
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to tax rule page");
		$I->comment("Entering Action Group [goToTaxRulePage] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRulePage
		$I->comment("Exiting Action Group [goToTaxRulePage] AdminTaxRuleGridOpenPageActionGroup");
		$I->click("#add"); // stepKey: addNewTaxRate
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateWaitForPageLoad
		$I->fillField("#anchor-content #code", "SampleRule"); // stepKey: fillRuleName
		$I->comment("Add NY and CA tax rules");
		$I->comment("Entering Action Group [addNYTaxRate] AddNewTaxRateNoZipActionGroup");
		$I->comment("Go to the tax rate page");
		$I->click("//*[text()='Add New Tax Rate']"); // stepKey: addNewTaxRateAddNYTaxRate
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddNYTaxRateWaitForPageLoad
		$I->comment("Fill out a new tax rate");
		$I->fillField("aside #code", "New York-8.375"); // stepKey: fillTaxIdentifierAddNYTaxRate
		$I->fillField("#tax_postcode", "*"); // stepKey: fillZipCodeAddNYTaxRate
		$I->selectOption("#tax_region_id", "New York"); // stepKey: selectStateAddNYTaxRate
		$I->selectOption("#tax_country_id", "United States"); // stepKey: selectCountryAddNYTaxRate
		$I->fillField("#rate", "8.375"); // stepKey: fillRateAddNYTaxRate
		$I->comment("Save the tax rate");
		$I->click(".action-save"); // stepKey: saveTaxRateAddNYTaxRate
		$I->waitForPageLoad(30); // stepKey: saveTaxRateAddNYTaxRateWaitForPageLoad
		$I->comment("Exiting Action Group [addNYTaxRate] AddNewTaxRateNoZipActionGroup");
		$I->comment("Entering Action Group [addCATaxRate] AddNewTaxRateNoZipActionGroup");
		$I->comment("Go to the tax rate page");
		$I->click("//*[text()='Add New Tax Rate']"); // stepKey: addNewTaxRateAddCATaxRate
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddCATaxRateWaitForPageLoad
		$I->comment("Fill out a new tax rate");
		$I->fillField("aside #code", "California-8.25"); // stepKey: fillTaxIdentifierAddCATaxRate
		$I->fillField("#tax_postcode", "*"); // stepKey: fillZipCodeAddCATaxRate
		$I->selectOption("#tax_region_id", "California"); // stepKey: selectStateAddCATaxRate
		$I->selectOption("#tax_country_id", "United States"); // stepKey: selectCountryAddCATaxRate
		$I->fillField("#rate", "8.25"); // stepKey: fillRateAddCATaxRate
		$I->comment("Save the tax rate");
		$I->click(".action-save"); // stepKey: saveTaxRateAddCATaxRate
		$I->waitForPageLoad(30); // stepKey: saveTaxRateAddCATaxRateWaitForPageLoad
		$I->comment("Exiting Action Group [addCATaxRate] AddNewTaxRateNoZipActionGroup");
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(90); // stepKey: clickSaveWaitForPageLoad
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Go to the tax rule page and delete the row we created");
		$I->comment("Entering Action Group [goToTaxRulesPage] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRulesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRulesPage
		$I->comment("Exiting Action Group [goToTaxRulesPage] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [deleteRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteRule
		$I->fillField(".col-code .admin__control-text", "SampleRule"); // stepKey: fillIdentifierDeleteRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteRule
		$I->comment("Exiting Action Group [deleteRule] deleteEntitySecondaryGrid");
		$I->comment("Go to the tax rate page");
		$I->comment("Entering Action Group [goToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRatesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRatesPage
		$I->comment("Exiting Action Group [goToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Delete the two tax rates that were created");
		$I->comment("Entering Action Group [deleteNYRate] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteNYRate
		$I->fillField(".col-code .admin__control-text", "New York-8.375"); // stepKey: fillIdentifierDeleteNYRate
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteNYRate
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteNYRate
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteNYRate
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteNYRate
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteNYRateWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteNYRate
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteNYRateWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteNYRate
		$I->comment("Exiting Action Group [deleteNYRate] deleteEntitySecondaryGrid");
		$I->comment("Entering Action Group [deleteCARate] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteCARate
		$I->fillField(".col-code .admin__control-text", "California-8.25"); // stepKey: fillIdentifierDeleteCARate
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteCARate
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteCARate
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteCARate
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteCARate
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCARateWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteCARate
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteCARateWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteCARate
		$I->comment("Exiting Action Group [deleteCARate] deleteEntitySecondaryGrid");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleproduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simplecategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("multiple_address_customer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Checkout"})
	 * @Stories({"Customer checkout"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCheckoutTestWithMultipleAddressesAndTaxRatesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('multiple_address_customer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('multiple_address_customer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simplecategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage1
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad1
		$I->comment("Entering Action Group [hoverProduct1] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct1
		$I->comment("Exiting Action Group [hoverProduct1] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart1] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart1
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart1
		$I->comment("Exiting Action Group [addToCart1] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded1
		$I->see("You added " . $I->retrieveEntityField('simpleproduct1', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage1
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity1
		$I->comment("Entering Action Group [goToCheckoutFromMinicart1] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart1
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart1
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart1
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicart1WaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart1
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicart1WaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart1] GoToCheckoutFromMinicartActionGroup");
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethod1
		$I->comment("Entering Action Group [clickNextOnShippingMethodLoad1] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextOnShippingMethodLoad1
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextOnShippingMethodLoad1WaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNextOnShippingMethodLoad1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextOnShippingMethodLoad1WaitForPageLoad
		$I->comment("Exiting Action Group [clickNextOnShippingMethodLoad1] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButton1
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButton1WaitForPageLoad
		$I->see("368 Broadway St.", ".payment-method._active div.billing-address-details"); // stepKey: seeBillingAddressIsCorrect1
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderButton1
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderSuccessPage1
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeSuccessMessage1
		$I->amOnPage("/" . $I->retrieveEntityField('simplecategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage2
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad2
		$I->comment("Entering Action Group [hoverProduct2] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct2
		$I->comment("Exiting Action Group [hoverProduct2] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart2] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart2
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart2
		$I->comment("Exiting Action Group [addToCart2] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded2
		$I->see("You added " . $I->retrieveEntityField('simpleproduct1', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage2
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity2
		$I->comment("Entering Action Group [goToCheckoutFromMinicart2] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart2
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart2
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart2
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicart2WaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart2
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicart2WaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart2] GoToCheckoutFromMinicartActionGroup");
		$I->click("//div/following-sibling::div/button[contains(@class, 'action-select-shipping-item')]"); // stepKey: changeShippingAddress
		$I->waitForElementNotVisible("//div[contains(@class, 'checkout-shipping-method')]/following-sibling::div[contains(@class, 'loading-mask')]", 30); // stepKey: waitForShippingMethodLoaderNotVisible
		$I->waitForElementVisible("//*[@id='checkout-shipping-method-load']//input[@class='radio']", 30); // stepKey: waitForShippingMethodRadioToBeVisible
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad23
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethod2
		$I->comment("Entering Action Group [clickNextOnShippingMethodLoad2] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextOnShippingMethodLoad2
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextOnShippingMethodLoad2WaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNextOnShippingMethodLoad2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextOnShippingMethodLoad2WaitForPageLoad
		$I->comment("Exiting Action Group [clickNextOnShippingMethodLoad2] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment2] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment2
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment2
		$I->comment("Exiting Action Group [selectCheckMoneyPayment2] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButton2
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButton2WaitForPageLoad
		$I->see("368 Broadway St.", ".payment-method._active div.billing-address-details"); // stepKey: seeBillingAddressIsCorrect2
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderButton2
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderButton2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderSuccessPage2
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeSuccessMessage2
	}
}
