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
 * @Title("MC-238: Customer should only see cart price rule discount if condition shipping postcode")
 * @Description("Customer should only see cart price rule discount if condition shipping postcode<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontCartPriceRulePostcodeTest.xml<br>")
 * @TestCaseId("MC-238")
 * @group SalesRule
 */
class StorefrontCartPriceRulePostcodeTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("createPreReqProduct", "hook", "_defaultProduct", ["createPreReqCategory"], []); // stepKey: createPreReqProduct
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
		$I->comment("Entering Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCleanUpRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCleanUpRule
		$I->fillField("input[name='name']", "SimpleSalesRule" . msq("SimpleSalesRule")); // stepKey: filterByNameCleanUpRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterCleanUpRule
		$I->waitForPageLoad(30); // stepKey: doFilterCleanUpRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageCleanUpRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageCleanUpRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonCleanUpRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonCleanUpRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteCleanUpRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteCleanUpRuleWaitForPageLoad
		$I->comment("Exiting Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("createPreReqProduct", "hook"); // stepKey: deletePreReqProduct
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPage
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
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCartPriceRulePostcodeTest(AcceptanceTester $I)
	{
		$I->comment("Create the rule...");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSalesRule" . msq("SimpleSalesRule")); // stepKey: fillRuleName
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsites
		$I->comment("Entering Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectNotLoggedInCustomerGroup
		$I->comment("Exiting Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("-1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$yesterdayDate = $date->format("m/d/Y");

		$I->fillField("input[name='from_date']", $yesterdayDate); // stepKey: fillFromDate
		$I->click("//div[@data-index='conditions']//span[contains(.,'Conditions')][1]"); // stepKey: expandConditions
		$I->comment("Scroll down to fix some flaky behavior...");
		$I->scrollTo("//div[@data-index='conditions']//span[contains(.,'Conditions')][1]"); // stepKey: scrollToConditionsTab
		$I->waitForElementVisible("span.rule-param.rule-param-new-child", 30); // stepKey: waitForNewRule
		$I->click("span.rule-param.rule-param-new-child"); // stepKey: clickNewRule
		$I->selectOption("select[data-form-part='sales_rule_form'][data-ui-id='newchild-0-select-rule-conditions-1-new-child']", "Shipping Postcode"); // stepKey: selectProductAttributes
		$I->waitForPageLoad(30); // stepKey: wait1
		$I->click("//*[@id='conditions__1__children']/li[1]/span[1]/a"); // stepKey: startEditOperator
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->selectOption("#conditions__1--1__operator", "is one of"); // stepKey: fillOperator
		$I->waitForPageLoad(30); // stepKey: wait3
		$I->click("//*[@id='conditions__1__children']/li[1]/span[2]/a"); // stepKey: startEditValue
		$I->waitForPageLoad(30); // stepKey: wait4
		$I->fillField("#conditions__1--1__value", "78613"); // stepKey: fillValue
		$I->waitForPageLoad(30); // stepKey: wait5
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: selectActionType
		$I->fillField("input[name='discount_amount']", "9.99"); // stepKey: fillDiscountAmount
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonWaitForPageLoad
		$I->see("You saved the rule.", ".messages"); // stepKey: seeSuccessMessage
		$I->comment("Add the product we created to our cart");
		$I->amOnPage($I->retrieveEntityField('createPreReqProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->fillField("#qty", "1"); // stepKey: fillQuantity
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Should not see the discount yet because we have not filled in postcode");
		$I->comment("Entering Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCartPage
		$I->comment("Exiting Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->click("#block-shipping-heading"); // stepKey: openEstimateShippingSection
		$I->waitForPageLoad(10); // stepKey: openEstimateShippingSectionWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectFlatRateShipping
		$I->waitForPageLoad(30); // stepKey: selectFlatRateShippingWaitForPageLoad
		$I->see("$123.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: seeSubtotal
		$I->dontSeeElement("td[data-th='Discount']"); // stepKey: dontSeeDiscount
		$I->comment("See discount if we use valid postcode");
		$I->fillField("input[name='postcode']", "78613"); // stepKey: fillPostcode
		$I->waitForPageLoad(10); // stepKey: fillPostcodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPostcode1
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeDiscountTotal
		$I->see("-$9.99", "td[data-th='Discount']"); // stepKey: assertDiscountSeeDiscountTotal
		$I->comment("Exiting Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->comment("Do not see discount with other postcode");
		$I->fillField("input[name='postcode']", "90210"); // stepKey: fillPostcode2
		$I->waitForPageLoad(10); // stepKey: fillPostcode2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPostcode2
		$I->dontSeeElement("td[data-th='Discount']"); // stepKey: dontSeeDiscount2
	}
}
