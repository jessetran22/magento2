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
 * @Title("MC-5821: Update tax rule, fixed zip Utah")
 * @Description("Test log in to Update tax rule and Update tax rule with fixed zip Utah<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminUpdateTaxRuleWithFixedZipUtahTest.xml<br>")
 * @TestCaseId("MC-5821")
 * @group tax
 * @group mtf_migrated
 */
class AdminUpdateTaxRuleWithFixedZipUtahTestCest
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
		$I->createEntity("initialTaxRule", "hook", "defaultTaxRule", [], []); // stepKey: initialTaxRule
		$I->createEntity("taxRateWithFixedZipUtah", "hook", "TaxRateWithFixedZipUtah", [], []); // stepKey: taxRateWithFixedZipUtah
		$I->createEntity("createCustomerTaxClass", "hook", "customerTaxClass", [], []); // stepKey: createCustomerTaxClass
		$I->createEntity("createProductTaxClass", "hook", "productTaxClass", [], []); // stepKey: createProductTaxClass
		$I->getEntity("customerTaxClass", "hook", "customerTaxClass", ["createCustomerTaxClass"], null); // stepKey: customerTaxClass
		$I->getEntity("productTaxClass", "hook", "productTaxClass", ["createProductTaxClass"], null); // stepKey: productTaxClass
		$I->createEntity("simpleProduct", "hook", "ApiSimplePrice100Qty100v2", [], []); // stepKey: simpleProduct
		$I->createEntity("customer", "hook", "Simple_US_Utah_Customer", [], []); // stepKey: customer
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->deleteEntity("taxRateWithFixedZipUtah", "hook"); // stepKey: deleteTaxRate
		$I->deleteEntity("createCustomerTaxClass", "hook"); // stepKey: deleteCustomerTaxClass
		$I->deleteEntity("createProductTaxClass", "hook"); // stepKey: deleteProductTaxClass
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Update tax rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Tax"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateTaxRuleWithFixedZipUtahTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRuleIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRuleIndex1
		$I->comment("Exiting Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters1
		$I->comment("Exiting Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->fillField("#taxRuleGrid_filter_code", $I->retrieveEntityField('initialTaxRule', 'code', 'test')); // stepKey: fillTaxCodeSearch
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch1
		$I->waitForPageLoad(30); // stepKey: clickSearch1WaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: clickFirstRow1
		$I->waitForPageLoad(30); // stepKey: clickFirstRow1WaitForPageLoad
		$I->comment("Update tax rule with fixed zip Utah");
		$I->fillField("#code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillTaxRuleCode1
		$I->fillField("input[data-role='advanced-select-text']", $I->retrieveEntityField('taxRateWithFixedZipUtah', 'code', 'test')); // stepKey: fillTaxRateSearch
		$I->wait(5); // stepKey: waitForSearch
		$I->click("//*[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//span[.='" . $I->retrieveEntityField('taxRateWithFixedZipUtah', 'code', 'test') . "']"); // stepKey: clickSelectNeededItem
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettings
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettingsWaitForPageLoad
		$I->scrollTo("#details-summarybase_fieldset", 0, -80); // stepKey: scrollToAdvancedSettings
		$I->waitForPageLoad(30); // stepKey: scrollToAdvancedSettingsWaitForPageLoad
		$I->wait(5); // stepKey: waitForAdditionalSettings
		$I->conditionalClick("//*[@id='tax_customer_class']/..//span[.='Retail Customer']", "//*[@id='tax_customer_class']/..//span[.='Retail Customer' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", false); // stepKey: checkRetailCustomerTaxClass
		$I->conditionalClick("//*[@id='tax_product_class']/..//span[.='Taxable Goods']", "//*[@id='tax_product_class']/..//span[.='Taxable Goods' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", false); // stepKey: checkTaxableGoodsTaxClass
		$I->click("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'test') . "']"); // stepKey: clickSelectProductTaxClass
		$I->click("#save"); // stepKey: clickSaveTaxRule
		$I->waitForPageLoad(30); // stepKey: clickSaveTaxRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSaved
		$I->comment("Verify we see success message");
		$I->see("You saved the tax rule.", "#messages"); // stepKey: seeAssertTaxRuleSuccessMessage
		$I->comment("Verify we see updated tax rule with fixed zip Utah(from the above step) on the tax rule grid page");
		$I->comment("Entering Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters2
		$I->comment("Exiting Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->fillField("#taxRuleGrid_filter_code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillTaxRuleCode2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSearch
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: clickFirstRow2
		$I->waitForPageLoad(30); // stepKey: clickFirstRow2WaitForPageLoad
		$I->comment("Verify we see updated tax rule with fixed zip Utah on the tax rule form page");
		$I->seeInField("#code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: seeInTaxRuleCode
		$I->seeElement("//span[contains(., '" . $I->retrieveEntityField('taxRateWithFixedZipUtah', 'code', 'test') . "') and preceding-sibling::input[contains(@class, 'mselect-checked')]]"); // stepKey: seeTaxRateSelected
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettings1
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettings1WaitForPageLoad
		$I->scrollTo("#details-summarybase_fieldset", 0, -80); // stepKey: scrollToAdvancedSettings1
		$I->waitForPageLoad(30); // stepKey: scrollToAdvancedSettings1WaitForPageLoad
		$I->seeElement("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'test') . "' and preceding-sibling::input[contains(@class, 'mselect-checked')]]"); // stepKey: seeProductTaxClass
		$I->comment("Verify if tax rule is applied on the store front product page");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoad
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenShoppingCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenShoppingCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenShoppingCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [fillShippingZipForm] FillShippingZipForm");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: openShippingDetailsFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: openShippingDetailsFillShippingZipFormWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillShippingZipForm
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForCountryFieldAppearsFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: waitForCountryFieldAppearsFillShippingZipFormWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountryFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: selectCountryFillShippingZipFormWaitForPageLoad
		$I->selectOption("select[name='region_id']", "Utah"); // stepKey: selectStateProvinceFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: selectStateProvinceFillShippingZipFormWaitForPageLoad
		$I->fillField("input[name='postcode']", "84001"); // stepKey: fillPostCodeFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: fillPostCodeFillShippingZipFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFormUpdateFillShippingZipForm
		$I->comment("Exiting Action Group [fillShippingZipForm] FillShippingZipForm");
		$I->scrollTo(".grand.totals .amount .price", 0, -80); // stepKey: scrollToOrderTotal
		$I->waitForElementVisible("span[data-th='Shipping']", 30); // stepKey: waitForShipping
		$I->see("$5.00", "span[data-th='Shipping']"); // stepKey: seeShipping
		$I->waitForElementVisible(".totals-tax .amount .price", 30); // stepKey: waitForTax
		$I->see("$20.00", ".totals-tax .amount .price"); // stepKey: seeAssertTaxAmount
		$I->waitForElementVisible(".grand.totals .amount .price", 30); // stepKey: waitForOrderTotal
		$I->see("$125.00", ".grand.totals .amount .price"); // stepKey: seeAssertGrandTotal
	}
}
