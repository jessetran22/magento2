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
 * @Title("MC-19524: Cart Total value when 100% discount applied through Cart Rule")
 * @Description("Cart Total value when 100% discount applied through Cart Rule<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontCartTotalValueWithFullDiscountUsingCartRuleTest.xml<br>")
 * @TestCaseId("MC-19524")
 * @group SalesRule
 */
class StorefrontCartTotalValueWithFullDiscountUsingCartRuleTestCest
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
		$I->comment("log in");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Set configurations");
		$setShippingMethodEnabled = $I->magentoCLI("config:set carriers/tablerate/active 1", 60); // stepKey: setShippingMethodEnabled
		$I->comment($setShippingMethodEnabled);
		$setShippingMethodConditionName = $I->magentoCLI("config:set carriers/tablerate/condition_name package_value", 60); // stepKey: setShippingMethodConditionName
		$I->comment($setShippingMethodConditionName);
		$setCatalogPrice = $I->magentoCLI("config:set tax/calculation/price_includes_tax 1", 60); // stepKey: setCatalogPrice
		$I->comment($setCatalogPrice);
		$setSippingPrice = $I->magentoCLI("config:set tax/calculation/shipping_includes_tax 1", 60); // stepKey: setSippingPrice
		$I->comment($setSippingPrice);
		$setCrossBorderTrade = $I->magentoCLI("config:set tax/calculation/cross_border_trade_enabled 0", 60); // stepKey: setCrossBorderTrade
		$I->comment($setCrossBorderTrade);
		$setDiscount = $I->magentoCLI("config:set tax/calculation/discount_tax 1", 60); // stepKey: setDiscount
		$I->comment($setDiscount);
		$setPrice = $I->magentoCLI("config:set tax/cart_display/price 2", 60); // stepKey: setPrice
		$I->comment($setPrice);
		$setSubtotal = $I->magentoCLI("config:set tax/cart_display/subtotal 2", 60); // stepKey: setSubtotal
		$I->comment($setSubtotal);
		$setFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 1", 60); // stepKey: setFreeShipping
		$I->comment($setFreeShipping);
		$I->createEntity("initialTaxRule", "hook", "defaultTaxRule", [], []); // stepKey: initialTaxRule
		$I->createEntity("initialTaxRate", "hook", "defaultTaxRate", [], []); // stepKey: initialTaxRate
		$I->comment("Go to tax rule page");
		$I->comment("Entering Action Group [goToTaxRulePage] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRulePage
		$I->comment("Exiting Action Group [goToTaxRulePage] AdminTaxRuleGridOpenPageActionGroup");
		$I->click("#add"); // stepKey: addNewTaxRate
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateWaitForPageLoad
		$I->fillField("#anchor-content #code", "SampleRule"); // stepKey: fillRuleName
		$I->comment("Add tax rule with 20% tax rate");
		$I->comment("Entering Action Group [addNYTaxRate] AddNewTaxRateNoZipActionGroup");
		$I->comment("Go to the tax rate page");
		$I->click("//*[text()='Add New Tax Rate']"); // stepKey: addNewTaxRateAddNYTaxRate
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddNYTaxRateWaitForPageLoad
		$I->comment("Fill out a new tax rate");
		$I->fillField("aside #code", "New York-20.00"); // stepKey: fillTaxIdentifierAddNYTaxRate
		$I->fillField("#tax_postcode", "*"); // stepKey: fillZipCodeAddNYTaxRate
		$I->selectOption("#tax_region_id", "New York"); // stepKey: selectStateAddNYTaxRate
		$I->selectOption("#tax_country_id", "United States"); // stepKey: selectCountryAddNYTaxRate
		$I->fillField("#rate", "20.00"); // stepKey: fillRateAddNYTaxRate
		$I->comment("Save the tax rate");
		$I->click(".action-save"); // stepKey: saveTaxRateAddNYTaxRate
		$I->waitForPageLoad(30); // stepKey: saveTaxRateAddNYTaxRateWaitForPageLoad
		$I->comment("Exiting Action Group [addNYTaxRate] AddNewTaxRateNoZipActionGroup");
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(90); // stepKey: clickSaveWaitForPageLoad
		$I->comment("Create cart price rule");
		$I->comment("Entering Action Group [createCartPriceRule] AdminCreateCartPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateCartPriceRule
		$I->click("#add"); // stepKey: clickAddNewRuleCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateCartPriceRule
		$I->fillField("input[name='name']", "TestSalesRule" . msq("SalesRuleWithFullDiscount")); // stepKey: fillRuleNameCreateCartPriceRule
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateCartPriceRule
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateCartPriceRule
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateCartPriceRuleWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateCartPriceRule
		$I->fillField("input[name='discount_amount']", "100"); // stepKey: fillDiscountAmountCreateCartPriceRule
		$I->click("#save"); // stepKey: clickSaveButtonCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateCartPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateCartPriceRule
		$I->comment("Exiting Action Group [createCartPriceRule] AdminCreateCartPriceRuleActionGroup");
		$I->comment("Create 3 simple product");
		$createSimpleProductFirstFields['price'] = "5.10";
		$I->createEntity("createSimpleProductFirst", "hook", "SimpleProduct2", [], $createSimpleProductFirstFields); // stepKey: createSimpleProductFirst
		$createSimpleProductSecondFields['price'] = "5.10";
		$I->createEntity("createSimpleProductSecond", "hook", "SimpleProduct2", [], $createSimpleProductSecondFields); // stepKey: createSimpleProductSecond
		$createSimpleProductThirdFields['price'] = "5.50";
		$I->createEntity("createSimpleProductThird", "hook", "SimpleProduct2", [], $createSimpleProductThirdFields); // stepKey: createSimpleProductThird
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Removed created Data");
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
		$I->comment("Delete the tax rate that were created");
		$I->comment("Entering Action Group [goToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRatesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRatesPage
		$I->comment("Exiting Action Group [goToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [deleteNYRate] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteNYRate
		$I->fillField(".col-code .admin__control-text", "New York-20.00"); // stepKey: fillIdentifierDeleteNYRate
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
		$I->comment("Entering Action Group [deleteCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteCartPriceRule
		$I->fillField("input[name='name']", "TestSalesRule" . msq("SalesRuleWithFullDiscount")); // stepKey: filterByNameDeleteCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCartPriceRule] DeleteCartPriceRuleByName");
		$I->comment("Delete products");
		$I->deleteEntity("createSimpleProductFirst", "hook"); // stepKey: deleteSimpleProductFirst
		$I->deleteEntity("createSimpleProductSecond", "hook"); // stepKey: deleteSimpleProductSecond
		$I->deleteEntity("createSimpleProductThird", "hook"); // stepKey: deleteSimpleProductThird
		$I->comment("Unset configuration");
		$unsetShippingMethodEnabled = $I->magentoCLI("config:set carriers/tablerate/active 0", 60); // stepKey: unsetShippingMethodEnabled
		$I->comment($unsetShippingMethodEnabled);
		$unsetCatalogPrice = $I->magentoCLI("config:set tax/calculation/price_includes_tax 0", 60); // stepKey: unsetCatalogPrice
		$I->comment($unsetCatalogPrice);
		$unsetSippingPrice = $I->magentoCLI("config:set tax/calculation/shipping_includes_tax 0", 60); // stepKey: unsetSippingPrice
		$I->comment($unsetSippingPrice);
		$unsetCrossBorderTrade = $I->magentoCLI("config:set tax/calculation/cross_border_trade_enabled 1", 60); // stepKey: unsetCrossBorderTrade
		$I->comment($unsetCrossBorderTrade);
		$unsetDiscount = $I->magentoCLI("config:set tax/calculation/discount_tax 0", 60); // stepKey: unsetDiscount
		$I->comment($unsetDiscount);
		$unsetPrice = $I->magentoCLI("config:set tax/cart_display/price 1", 60); // stepKey: unsetPrice
		$I->comment($unsetPrice);
		$unsetSubtotal = $I->magentoCLI("config:set tax/cart_display/subtotal 1", 60); // stepKey: unsetSubtotal
		$I->comment($unsetSubtotal);
		$unsetFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 0", 60); // stepKey: unsetFreeShipping
		$I->comment($unsetFreeShipping);
		$I->comment("Log out");
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
	 * @Features({"SalesRule"})
	 * @Stories({"Cart total with full discount"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCartTotalValueWithFullDiscountUsingCartRuleTest(AcceptanceTester $I)
	{
		$I->comment("Add testing products to the cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProductFirst', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->fillField("#qty", "2"); // stepKey: setQuantity
		$I->comment("Entering Action Group [addProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCard
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCardWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCard
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCard
		$I->see("You added " . $I->retrieveEntityField('createSimpleProductFirst', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCard
		$I->comment("Exiting Action Group [addProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProductSecond', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToSecondProductPage
		$I->fillField("#qty", "2"); // stepKey: setQuantityForTheSecondProduct
		$I->comment("Entering Action Group [addSecondProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondProductToCard
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondProductToCardWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondProductToCard
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondProductToCard
		$I->see("You added " . $I->retrieveEntityField('createSimpleProductSecond', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondProductToCard
		$I->comment("Exiting Action Group [addSecondProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProductThird', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToThirdProductPage
		$I->fillField("#qty", "2"); // stepKey: setQuantityForTheThirdProduct
		$I->comment("Entering Action Group [addThirdProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddThirdProductToCard
		$I->waitForPageLoad(60); // stepKey: addToCartAddThirdProductToCardWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddThirdProductToCard
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddThirdProductToCard
		$I->see("You added " . $I->retrieveEntityField('createSimpleProductThird', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddThirdProductToCard
		$I->comment("Exiting Action Group [addThirdProductToCard] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->see("6", "span.counter-number"); // stepKey: seeCartQuantity
		$I->comment("Go to the shopping cart page");
		$I->comment("Entering Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnPageShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnPageShoppingCart
		$I->comment("Exiting Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->waitForElementVisible(".grand.totals .amount .price", 30); // stepKey: waitForOrderTotalVisible
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountry
		$I->waitForPageLoad(10); // stepKey: selectCountryWaitForPageLoad
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [seeDiscountAmount] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeDiscountAmount
		$I->see("-$29.00", "td[data-th='Discount']"); // stepKey: assertDiscountSeeDiscountAmount
		$I->comment("Exiting Action Group [seeDiscountAmount] AssertStorefrontCartDiscountActionGroup");
		$I->see("$29.00", "span[data-th='Subtotal']"); // stepKey: seeSubTotal
		$I->see("0.00", ".grand.totals .amount .price"); // stepKey: seeOrderTotal
	}
}
