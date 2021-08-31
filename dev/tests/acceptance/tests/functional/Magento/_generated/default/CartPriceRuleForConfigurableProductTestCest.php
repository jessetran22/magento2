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
 * @Title("MAGETWO-94471: Checking Cart Price Rule for configurable products")
 * @Description("Checking Cart Price Rule for configurable products<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/CartPriceRuleForConfigurableProductTest.xml<br>")
 * @TestCaseId("MAGETWO-94471")
 * @group SalesRule
 */
class CartPriceRuleForConfigurableProductTestCest
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
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product and add it to the category");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the option of the attribute we created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create a simple product and give it the attribute with option");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->comment("Add simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$runCronIndexer = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndexer
		$I->comment($runCronIndexer);
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
		$I->comment("Entering Action Group [DeleteCartPriceRuleByName] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteCartPriceRuleByName
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteCartPriceRuleByName
		$I->fillField("input[name='name']", "SimpleSalesRule" . msq("SimpleSalesRule")); // stepKey: filterByNameDeleteCartPriceRuleByName
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteCartPriceRuleByName
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteCartPriceRuleByNameWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteCartPriceRuleByName
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteCartPriceRuleByNameWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteCartPriceRuleByName
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteCartPriceRuleByNameWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteCartPriceRuleByName
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteCartPriceRuleByNameWaitForPageLoad
		$I->comment("Exiting Action Group [DeleteCartPriceRuleByName] DeleteCartPriceRuleByName");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteApiCategory
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"SalesRule"})
	 * @Stories({"MAGETWO-94407 - Cart Price Rule for configurable products"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CartPriceRuleForConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Create the rule");
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
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->fillField("input[name='coupon_code']", "ABCD"); // stepKey: fillCouponCOde
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmount
		$I->scrollTo(".rule-param.rule-param-new-child > a"); // stepKey: ScrollToApplyRuleForConditions
		$I->click(".rule-param.rule-param-new-child > a"); // stepKey: ApplyRuleForConditions
		$I->waitForPageLoad(30); // stepKey: waitForDropDownOpened
		$I->selectOption("//select[contains(@name, 'new_child')]", $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test')); // stepKey: selectAttribute
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpened
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickToChooseCondition
		$I->selectOption("//select[contains(@name, '[operator]')]", "is not"); // stepKey: selectOperator
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpened1
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooseOption
		$I->waitForPageLoad(30); // stepKey: waitForConditionOpened2
		$I->selectOption("//ul[@class='rule-param-children']//select[contains(@name, '[value]')]", "option1"); // stepKey: selectOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoaded
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonWaitForPageLoad
		$I->see("You saved the rule.", ".messages"); // stepKey: seeSuccessMessage
		$I->comment("Add the first product to the cart");
		$I->amOnPage($I->retrieveEntityField('createConfigChildProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Add the second product to the cart");
		$I->amOnPage($I->retrieveEntityField('createConfigChildProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage2] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage2] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("View and edit cart");
		$I->comment("Entering Action Group [clickViewAndEditCartFromMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartClickViewAndEditCartFromMiniCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartClickViewAndEditCartFromMiniCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartClickViewAndEditCartFromMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleClickViewAndEditCartFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleClickViewAndEditCartFromMiniCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartClickViewAndEditCartFromMiniCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartClickViewAndEditCartFromMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickViewAndEditCartFromMiniCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlClickViewAndEditCartFromMiniCart
		$I->comment("Exiting Action Group [clickViewAndEditCartFromMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->click("//*[text()='Apply Discount Code']"); // stepKey: scrollToDiscountTab
		$I->fillField("#coupon_code", "ABCD"); // stepKey: fillCouponCode
		$I->click("//span[text()='Apply Discount']"); // stepKey: applyCode
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->see("You used coupon code"); // stepKey: assertText
		$I->comment("Verify values");
		$getDiscount = $I->grabTextFrom("//tr[@class='totals']//td[@class='amount']/span"); // stepKey: getDiscount
		$getSubtotal = $I->grabTextFrom("//tr[@class='totals sub']//td[@class='amount']/span"); // stepKey: getSubtotal
		$I->assertEquals("-$117.00", $getDiscount); // stepKey: checkDescount
		$I->assertEquals("$357.00", $getSubtotal); // stepKey: checkSubtotal
	}
}
