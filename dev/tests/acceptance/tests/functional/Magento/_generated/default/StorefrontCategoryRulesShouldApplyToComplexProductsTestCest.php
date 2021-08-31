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
 * @Title("MAGETWO-70192: Category rules should apply to complex products")
 * @Description("Sales rules filtering on category should apply to all products, including complex products.<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontCategoryRulesShouldApplyToComplexProductsTest.xml<br>")
 * @TestCaseId("MAGETWO-70192")
 * @group catalogRule
 */
class StorefrontCategoryRulesShouldApplyToComplexProductsTestCest
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
		$I->comment("Create two Categories: CAT1 and CAT2");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createCategory2", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory2
		$I->comment("Create config1 and config2");
		$I->comment("Entering Action Group [createConfigurableProduct1] AdminCreateApiConfigurableProductWithHiddenChildActionGroup");
		$I->comment("Create the configurable product based on the data in the /data folder");
		$createConfigProductCreateConfigurableProduct1Fields['name'] = "config1";
		$I->createEntity("createConfigProductCreateConfigurableProduct1", "hook", "ApiConfigurableProductWithOutCategory", [], $createConfigProductCreateConfigurableProduct1Fields); // stepKey: createConfigProductCreateConfigurableProduct1
		$I->comment("Create attribute with 2 options to be used in children products");
		$I->createEntity("createConfigProductAttributeCreateConfigurableProduct1", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeCreateConfigurableProduct1
		$I->createEntity("createConfigProductAttributeOption1CreateConfigurableProduct1", "hook", "productAttributeOption1", ["createConfigProductAttributeCreateConfigurableProduct1"], []); // stepKey: createConfigProductAttributeOption1CreateConfigurableProduct1
		$I->createEntity("createConfigProductAttributeOption2CreateConfigurableProduct1", "hook", "productAttributeOption2", ["createConfigProductAttributeCreateConfigurableProduct1"], []); // stepKey: createConfigProductAttributeOption2CreateConfigurableProduct1
		$I->createEntity("addAttributeToAttributeSetCreateConfigurableProduct1", "hook", "AddToDefaultSet", ["createConfigProductAttributeCreateConfigurableProduct1"], []); // stepKey: addAttributeToAttributeSetCreateConfigurableProduct1
		$I->getEntity("getConfigAttributeOption1CreateConfigurableProduct1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct1"], null, 1); // stepKey: getConfigAttributeOption1CreateConfigurableProduct1
		$I->getEntity("getConfigAttributeOption2CreateConfigurableProduct1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct1"], null, 2); // stepKey: getConfigAttributeOption2CreateConfigurableProduct1
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1CreateConfigurableProduct1", "hook", "ApiSimpleOneHidden", ["createConfigProductAttributeCreateConfigurableProduct1", "getConfigAttributeOption1CreateConfigurableProduct1"], []); // stepKey: createConfigChildProduct1CreateConfigurableProduct1
		$I->createEntity("createConfigChildProduct2CreateConfigurableProduct1", "hook", "ApiSimpleTwoHidden", ["createConfigProductAttributeCreateConfigurableProduct1", "getConfigAttributeOption2CreateConfigurableProduct1"], []); // stepKey: createConfigChildProduct2CreateConfigurableProduct1
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOptionCreateConfigurableProduct1", "hook", "ConfigurableProductTwoOptions", ["createConfigProductCreateConfigurableProduct1", "createConfigProductAttributeCreateConfigurableProduct1", "getConfigAttributeOption1CreateConfigurableProduct1", "getConfigAttributeOption2CreateConfigurableProduct1"], []); // stepKey: createConfigProductOptionCreateConfigurableProduct1
		$I->createEntity("createConfigProductAddChild1CreateConfigurableProduct1", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct1", "createConfigChildProduct1CreateConfigurableProduct1"], []); // stepKey: createConfigProductAddChild1CreateConfigurableProduct1
		$I->createEntity("createConfigProductAddChild2CreateConfigurableProduct1", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct1", "createConfigChildProduct2CreateConfigurableProduct1"], []); // stepKey: createConfigProductAddChild2CreateConfigurableProduct1
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->comment("Exiting Action Group [createConfigurableProduct1] AdminCreateApiConfigurableProductWithHiddenChildActionGroup");
		$I->comment("Entering Action Group [createConfigurableProduct2] AdminCreateApiConfigurableProductWithHiddenChildActionGroup");
		$I->comment("Create the configurable product based on the data in the /data folder");
		$createConfigProductCreateConfigurableProduct2Fields['name'] = "config2";
		$I->createEntity("createConfigProductCreateConfigurableProduct2", "hook", "ApiConfigurableProductWithOutCategory", [], $createConfigProductCreateConfigurableProduct2Fields); // stepKey: createConfigProductCreateConfigurableProduct2
		$I->comment("Create attribute with 2 options to be used in children products");
		$I->createEntity("createConfigProductAttributeCreateConfigurableProduct2", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeCreateConfigurableProduct2
		$I->createEntity("createConfigProductAttributeOption1CreateConfigurableProduct2", "hook", "productAttributeOption1", ["createConfigProductAttributeCreateConfigurableProduct2"], []); // stepKey: createConfigProductAttributeOption1CreateConfigurableProduct2
		$I->createEntity("createConfigProductAttributeOption2CreateConfigurableProduct2", "hook", "productAttributeOption2", ["createConfigProductAttributeCreateConfigurableProduct2"], []); // stepKey: createConfigProductAttributeOption2CreateConfigurableProduct2
		$I->createEntity("addAttributeToAttributeSetCreateConfigurableProduct2", "hook", "AddToDefaultSet", ["createConfigProductAttributeCreateConfigurableProduct2"], []); // stepKey: addAttributeToAttributeSetCreateConfigurableProduct2
		$I->getEntity("getConfigAttributeOption1CreateConfigurableProduct2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct2"], null, 1); // stepKey: getConfigAttributeOption1CreateConfigurableProduct2
		$I->getEntity("getConfigAttributeOption2CreateConfigurableProduct2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct2"], null, 2); // stepKey: getConfigAttributeOption2CreateConfigurableProduct2
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1CreateConfigurableProduct2", "hook", "ApiSimpleOneHidden", ["createConfigProductAttributeCreateConfigurableProduct2", "getConfigAttributeOption1CreateConfigurableProduct2"], []); // stepKey: createConfigChildProduct1CreateConfigurableProduct2
		$I->createEntity("createConfigChildProduct2CreateConfigurableProduct2", "hook", "ApiSimpleTwoHidden", ["createConfigProductAttributeCreateConfigurableProduct2", "getConfigAttributeOption2CreateConfigurableProduct2"], []); // stepKey: createConfigChildProduct2CreateConfigurableProduct2
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOptionCreateConfigurableProduct2", "hook", "ConfigurableProductTwoOptions", ["createConfigProductCreateConfigurableProduct2", "createConfigProductAttributeCreateConfigurableProduct2", "getConfigAttributeOption1CreateConfigurableProduct2", "getConfigAttributeOption2CreateConfigurableProduct2"], []); // stepKey: createConfigProductOptionCreateConfigurableProduct2
		$I->createEntity("createConfigProductAddChild1CreateConfigurableProduct2", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct2", "createConfigChildProduct1CreateConfigurableProduct2"], []); // stepKey: createConfigProductAddChild1CreateConfigurableProduct2
		$I->createEntity("createConfigProductAddChild2CreateConfigurableProduct2", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct2", "createConfigChildProduct2CreateConfigurableProduct2"], []); // stepKey: createConfigProductAddChild2CreateConfigurableProduct2
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->comment("Exiting Action Group [createConfigurableProduct2] AdminCreateApiConfigurableProductWithHiddenChildActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Assign config1 and the associated  child products to CAT1");
		$I->comment("Entering Action Group [assignConfigurableProduct1ToCategory] AdminAssignProductToCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct1', 'id', 'hook')); // stepKey: amOnPageAssignConfigurableProduct1ToCategory
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'hook')]); // stepKey: selectCategoryAssignConfigurableProduct1ToCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignConfigurableProduct1ToCategoryWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButtonAssignConfigurableProduct1ToCategory
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAssignConfigurableProduct1ToCategoryWaitForPageLoad
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveProductMessageAssignConfigurableProduct1ToCategory
		$I->comment("Exiting Action Group [assignConfigurableProduct1ToCategory] AdminAssignProductToCategoryActionGroup");
		$I->comment("Entering Action Group [assignConfig1ChildProduct1ToCategory] AdminAssignProductToCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1CreateConfigurableProduct1', 'id', 'hook')); // stepKey: amOnPageAssignConfig1ChildProduct1ToCategory
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'hook')]); // stepKey: selectCategoryAssignConfig1ChildProduct1ToCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignConfig1ChildProduct1ToCategoryWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButtonAssignConfig1ChildProduct1ToCategory
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAssignConfig1ChildProduct1ToCategoryWaitForPageLoad
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveProductMessageAssignConfig1ChildProduct1ToCategory
		$I->comment("Exiting Action Group [assignConfig1ChildProduct1ToCategory] AdminAssignProductToCategoryActionGroup");
		$I->comment("Entering Action Group [assignConfig1ChildProduct2ToCategory] AdminAssignProductToCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2CreateConfigurableProduct1', 'id', 'hook')); // stepKey: amOnPageAssignConfig1ChildProduct2ToCategory
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'hook')]); // stepKey: selectCategoryAssignConfig1ChildProduct2ToCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignConfig1ChildProduct2ToCategoryWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButtonAssignConfig1ChildProduct2ToCategory
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAssignConfig1ChildProduct2ToCategoryWaitForPageLoad
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveProductMessageAssignConfig1ChildProduct2ToCategory
		$I->comment("Exiting Action Group [assignConfig1ChildProduct2ToCategory] AdminAssignProductToCategoryActionGroup");
		$I->comment("Assign config12 and the associated  child products to CAT2");
		$I->comment("Entering Action Group [assignConfigurableProduct2ToCategory2] AdminAssignProductToCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct2', 'id', 'hook')); // stepKey: amOnPageAssignConfigurableProduct2ToCategory2
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory2', 'name', 'hook')]); // stepKey: selectCategoryAssignConfigurableProduct2ToCategory2
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignConfigurableProduct2ToCategory2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButtonAssignConfigurableProduct2ToCategory2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAssignConfigurableProduct2ToCategory2WaitForPageLoad
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveProductMessageAssignConfigurableProduct2ToCategory2
		$I->comment("Exiting Action Group [assignConfigurableProduct2ToCategory2] AdminAssignProductToCategoryActionGroup");
		$I->comment("Entering Action Group [assignConfig2ChildProduct1ToCategory2] AdminAssignProductToCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1CreateConfigurableProduct2', 'id', 'hook')); // stepKey: amOnPageAssignConfig2ChildProduct1ToCategory2
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory2', 'name', 'hook')]); // stepKey: selectCategoryAssignConfig2ChildProduct1ToCategory2
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignConfig2ChildProduct1ToCategory2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButtonAssignConfig2ChildProduct1ToCategory2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAssignConfig2ChildProduct1ToCategory2WaitForPageLoad
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveProductMessageAssignConfig2ChildProduct1ToCategory2
		$I->comment("Exiting Action Group [assignConfig2ChildProduct1ToCategory2] AdminAssignProductToCategoryActionGroup");
		$I->comment("Entering Action Group [assignConfig2ChildProduct2ToCategory2] AdminAssignProductToCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2CreateConfigurableProduct2', 'id', 'hook')); // stepKey: amOnPageAssignConfig2ChildProduct2ToCategory2
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory2', 'name', 'hook')]); // stepKey: selectCategoryAssignConfig2ChildProduct2ToCategory2
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignConfig2ChildProduct2ToCategory2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButtonAssignConfig2ChildProduct2ToCategory2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonAssignConfig2ChildProduct2ToCategory2WaitForPageLoad
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveProductMessageAssignConfig2ChildProduct2ToCategory2
		$I->comment("Exiting Action Group [assignConfig2ChildProduct2ToCategory2] AdminAssignProductToCategoryActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable product 1");
		$I->deleteEntity("createConfigProductCreateConfigurableProduct1", "hook"); // stepKey: deleteConfigProduct1
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory1
		$I->deleteEntity("createConfigChildProduct1CreateConfigurableProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2CreateConfigurableProduct1", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttributeCreateConfigurableProduct1", "hook"); // stepKey: deleteConfigProductAttribute1
		$I->comment("Delete configurable product 2");
		$I->deleteEntity("createConfigProductCreateConfigurableProduct2", "hook"); // stepKey: deleteConfigProduct2
		$I->deleteEntity("createCategory2", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("createConfigChildProduct1CreateConfigurableProduct2", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigChildProduct2CreateConfigurableProduct2", "hook"); // stepKey: deleteConfigChildProduct4
		$I->deleteEntity("createConfigProductAttributeCreateConfigurableProduct2", "hook"); // stepKey: deleteConfigProductAttribute2
		$I->comment("Delete Cart Price Rule");
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteCartPriceRule
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
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCategoryRulesShouldApplyToComplexProductsTest(AcceptanceTester $I)
	{
		$I->comment("1: Create a cart price rule applying to CAT1 with discount");
		$I->createEntity("createCartPriceRule", "test", "SalesRuleNoCouponWithFixedDiscount", [], []); // stepKey: createCartPriceRule
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/edit/id/" . $I->retrieveEntityField('createCartPriceRule', 'rule_id', 'test')); // stepKey: goToCartPriceRuleEditPage
		$I->comment("Entering Action Group [setConditionForActionsInCartPriceRuleActionGroup] SetConditionForActionsInCartPriceRuleActionGroup");
		$I->click("div[data-index='actions']"); // stepKey: clickOnActionTabSetConditionForActionsInCartPriceRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: clickOnActionTabSetConditionForActionsInCartPriceRuleActionGroupWaitForPageLoad
		$I->click("//span[@class='rule-param']/a[text()='ALL']"); // stepKey: clickToChooseOptionSetConditionForActionsInCartPriceRuleActionGroup
		$I->selectOption("#actions__1__aggregator", "ANY"); // stepKey: selectConditionSetConditionForActionsInCartPriceRuleActionGroup
		$I->click("//span[@class='rule-param']/a[text()='TRUE']"); // stepKey: clickToChooseOption2SetConditionForActionsInCartPriceRuleActionGroup
		$I->selectOption("#actions__1__value", "FALSE"); // stepKey: selectCondition2SetConditionForActionsInCartPriceRuleActionGroup
		$I->click(".rule-param.rule-param-new-child > a"); // stepKey: selectActionConditionsSetConditionForActionsInCartPriceRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForDropDownOpenedSetConditionForActionsInCartPriceRuleActionGroup
		$I->selectOption("//select[contains(@name, 'new_child')]", "Category"); // stepKey: selectAttributeSetConditionForActionsInCartPriceRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForOperatorOpenedSetConditionForActionsInCartPriceRuleActionGroup
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooseOption3SetConditionForActionsInCartPriceRuleActionGroup
		$I->fillField(".rule-param-edit input", $I->retrieveEntityField('createCategory', 'id', 'test')); // stepKey: fillActionValueSetConditionForActionsInCartPriceRuleActionGroup
		$I->click(".rule-param-apply"); // stepKey: applyActionSetConditionForActionsInCartPriceRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: applyActionSetConditionForActionsInCartPriceRuleActionGroupWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSetConditionForActionsInCartPriceRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSetConditionForActionsInCartPriceRuleActionGroupWaitForPageLoad
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageSetConditionForActionsInCartPriceRuleActionGroup
		$I->comment("Exiting Action Group [setConditionForActionsInCartPriceRuleActionGroup] SetConditionForActionsInCartPriceRuleActionGroup");
		$I->comment("2: Go to frontend and add an item from both CAT1 and CAT2 to your cart");
		$I->comment("Entering Action Group [goToFrontend] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontend
		$I->comment("Exiting Action Group [goToFrontend] StorefrontOpenHomePageActionGroup");
		$I->comment("3: Open configurable product 1 and add all his child products to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnConfigurableProductPage
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct1', 'attribute[frontend_labels][0][label]', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeOption1CreateConfigurableProduct1', 'option[store_labels][0][label]', 'test')); // stepKey: selectOption
		$I->comment("Entering Action Group [cartAddConfigurableProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddConfigurableProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddConfigurableProductToCart
		$I->see("You added " . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct1', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddConfigurableProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddConfigurableProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddConfigurableProductToCart
		$I->comment("Exiting Action Group [cartAddConfigurableProductToCart] StorefrontAddProductToCartActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct1', 'attribute[frontend_labels][0][label]', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeOption2CreateConfigurableProduct1', 'option[store_labels][0][label]', 'test')); // stepKey: selectOption2
		$I->comment("Entering Action Group [cartAddConfigurableProductToCart2] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddConfigurableProductToCart2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddConfigurableProductToCart2
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddConfigurableProductToCart2
		$I->see("You added " . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct1', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart2
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart2WaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddConfigurableProductToCart2
		$I->waitForText("2", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddConfigurableProductToCart2
		$I->comment("Exiting Action Group [cartAddConfigurableProductToCart2] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [goToCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToCart
		$I->comment("Exiting Action Group [goToCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Discount amount is not applied");
		$I->dontSee("//*[@id='cart-totals']//tr[.//th//span[contains(@class, 'discount coupon')]]"); // stepKey: discountIsNotApply
		$I->comment("3: Open configurable product 2 and add all his child products to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnConfigurableProductPage2
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct2', 'attribute[frontend_labels][0][label]', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeOption1CreateConfigurableProduct2', 'option[store_labels][0][label]', 'test')); // stepKey: selectOption3
		$I->comment("Entering Action Group [cartAddConfigurableProductToCart3] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddConfigurableProductToCart3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddConfigurableProductToCart3
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddConfigurableProductToCart3
		$I->see("You added " . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct2', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart3
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart3WaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddConfigurableProductToCart3
		$I->waitForText("3", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddConfigurableProductToCart3
		$I->comment("Exiting Action Group [cartAddConfigurableProductToCart3] StorefrontAddProductToCartActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct2', 'attribute[frontend_labels][0][label]', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeOption2CreateConfigurableProduct2', 'option[store_labels][0][label]', 'test')); // stepKey: selectOption4
		$I->comment("Entering Action Group [cartAddConfigurableProductToCart4] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddConfigurableProductToCart4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddConfigurableProductToCart4
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddConfigurableProductToCart4
		$I->see("You added " . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct2', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart4
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddConfigurableProductToCart4WaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddConfigurableProductToCart4
		$I->waitForText("4", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddConfigurableProductToCart4
		$I->comment("Exiting Action Group [cartAddConfigurableProductToCart4] StorefrontAddProductToCartActionGroup");
		$I->comment("Discount  amount is applied");
		$I->comment("Entering Action Group [goToCart2] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToCart2
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToCart2WaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToCart2
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToCart2
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToCart2WaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToCart2
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCart2
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToCart2
		$I->comment("Exiting Action Group [goToCart2] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->see("-$100.00", "//*[@id='cart-totals']//tr[.//th//span[contains(@class, 'discount coupon')]]//td//span//span[@class='price']"); // stepKey: discountIsApply
	}
}
