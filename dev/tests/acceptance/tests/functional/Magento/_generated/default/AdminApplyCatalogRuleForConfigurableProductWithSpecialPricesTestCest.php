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
 * @Title("MC-149: Admin should be able to apply the catalog price rule for configurable product with special prices")
 * @Description("Admin should be able to apply the catalog price rule for configurable product with special prices<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminApplyCatalogRuleForConfigurableProductWithSpecialPricesTest.xml<br>")
 * @TestCaseId("MC-149")
 * @group Catalog
 */
class AdminApplyCatalogRuleForConfigurableProductWithSpecialPricesTestCest
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
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Add two options to the configurable product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeFirstOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeFirstOption
		$I->createEntity("createConfigProductAttributeSecondOption", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeSecondOption
		$I->comment("Add created options to the default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeFirstOption
		$I->getEntity("getConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeSecondOption
		$I->comment("Create two children products that will be a part of the configurable product");
		$I->createEntity("createFirstConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeFirstOption"], []); // stepKey: createFirstConfigChildProduct
		$I->createEntity("createSecondConfigChildProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeSecondOption"], []); // stepKey: createSecondConfigChildProduct
		$I->comment("Assign two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductThreeOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeFirstOption", "getConfigAttributeSecondOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddFirstChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createFirstConfigChildProduct"], []); // stepKey: createConfigProductAddFirstChild
		$I->createEntity("createConfigProductAddSecondChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createSecondConfigChildProduct"], []); // stepKey: createConfigProductAddSecondChild
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the catalog price rule");
		$I->comment("Entering Action Group [openCatalogPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageOpenCatalogPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCatalogPriceRulePage
		$I->comment("Exiting Action Group [openCatalogPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillIdentifierDeletePriceRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeletePriceRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeletePriceRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeletePriceRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeletePriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeletePriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeletePriceRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeletePriceRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeletePriceRule
		$I->comment("Exiting Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Delete all created data");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createFirstConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createSecondConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"CatalogRule"})
	 * @Stories({"Apply catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminApplyCatalogRuleForConfigurableProductWithSpecialPricesTest(AcceptanceTester $I)
	{
		$I->comment("Add special prices for products");
		$I->comment("Entering Action Group [goToFirstChildProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFirstConfigChildProduct', 'id', 'test')); // stepKey: goToProductGoToFirstChildProduct
		$I->comment("Exiting Action Group [goToFirstChildProduct] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addSpecialPriceForFirstProduct] AddSpecialPriceToProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSpecialPriceForFirstProduct
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddSpecialPriceForFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddSpecialPriceForFirstProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalAddSpecialPriceForFirstProduct
		$I->waitForElementVisible("input[name='product[special_price]']", 30); // stepKey: waitSpecialPriceAddSpecialPriceForFirstProduct
		$I->fillField("input[name='product[special_price]']", "99.99"); // stepKey: fillSpecialPriceAddSpecialPriceForFirstProduct
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneAddSpecialPriceForFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAddSpecialPriceForFirstProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalGoneAddSpecialPriceForFirstProduct
		$I->waitForElementNotVisible("input[name='product[special_price]']", 30); // stepKey: waitForCloseModalWindowAddSpecialPriceForFirstProduct
		$I->comment("Exiting Action Group [addSpecialPriceForFirstProduct] AddSpecialPriceToProductActionGroup");
		$I->comment("Entering Action Group [saveFirstProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveFirstProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveFirstProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveFirstProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveFirstProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveFirstProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveFirstProduct
		$I->comment("Exiting Action Group [saveFirstProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [goToSecondChildProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSecondConfigChildProduct', 'id', 'test')); // stepKey: goToProductGoToSecondChildProduct
		$I->comment("Exiting Action Group [goToSecondChildProduct] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addSpecialPriceForSecondProduct] AddSpecialPriceToProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSpecialPriceForSecondProduct
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddSpecialPriceForSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddSpecialPriceForSecondProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalAddSpecialPriceForSecondProduct
		$I->waitForElementVisible("input[name='product[special_price]']", 30); // stepKey: waitSpecialPriceAddSpecialPriceForSecondProduct
		$I->fillField("input[name='product[special_price]']", "99.99"); // stepKey: fillSpecialPriceAddSpecialPriceForSecondProduct
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneAddSpecialPriceForSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAddSpecialPriceForSecondProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalGoneAddSpecialPriceForSecondProduct
		$I->waitForElementNotVisible("input[name='product[special_price]']", 30); // stepKey: waitForCloseModalWindowAddSpecialPriceForSecondProduct
		$I->comment("Exiting Action Group [addSpecialPriceForSecondProduct] AddSpecialPriceToProductActionGroup");
		$I->comment("Entering Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondProduct
		$I->comment("Exiting Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->comment("Create a new catalog price rule");
		$I->comment("Entering Action Group [newCatalogPriceRuleByUIWithConditionIsCategory] NewCatalogPriceRuleByUIWithConditionIsCategoryActionGroup");
		$I->comment("Go to the admin Catalog rule grid and add a new one");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("#add"); // stepKey: addNewRuleNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: addNewRuleNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->comment("Fill the form according the attributes of the entity");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("input[name='is_active']+label"); // stepKey: selectActiveNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='website_ids']", "1"); // stepKey: selectSiteNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[name='from_date'] + button"); // stepKey: clickFromCalenderNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(15); // stepKey: clickFromCalenderNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickFromTodayNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[name='to_date'] + button"); // stepKey: clickToCalenderNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(15); // stepKey: clickToCalenderNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickToTodayNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountValueNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: discountTypeNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRulesNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("[data-index='block_promo_catalog_edit_tab_conditions']"); // stepKey: openConditionsTabNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: addNewConditionNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", "Magento\CatalogRule\Model\Rule\Condition\Product|category_ids"); // stepKey: selectTypeConditionNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConditionChosedNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("//li[1]//a[@class='label'][text() = '...']"); // stepKey: clickEllipsisNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->fillField("input#conditions__1--1__value", $I->retrieveEntityField('createCategory', 'id', 'test')); // stepKey: fillCategoryIdNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->click("#conditions__1__children li:nth-of-type(1) a.rule-param-apply"); // stepKey: clickApplyNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: clickApplyNewCatalogPriceRuleByUIWithConditionIsCategoryWaitForPageLoad
		$I->comment("Scroll to top and either save or save and apply after the action group");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->waitForPageLoad(30); // stepKey: waitForAppliedNewCatalogPriceRuleByUIWithConditionIsCategory
		$I->comment("Exiting Action Group [newCatalogPriceRuleByUIWithConditionIsCategory] NewCatalogPriceRuleByUIWithConditionIsCategoryActionGroup");
		$I->comment("Select not logged in customer group");
		$I->comment("Entering Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectNotLoggedInCustomerGroup
		$I->comment("Exiting Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("Save and apply the new catalog price rule");
		$I->comment("Entering Action Group [saveAndApplyCatalogPriceRule] SaveAndApplyCatalogPriceRuleActionGroup");
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplySaveAndApplyCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplySaveAndApplyCatalogPriceRuleWaitForPageLoad
		$I->see("You saved the rule.", ".message-success"); // stepKey: assertSuccessSaveAndApplyCatalogPriceRule
		$I->comment("Exiting Action Group [saveAndApplyCatalogPriceRule] SaveAndApplyCatalogPriceRuleActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Open Storefront product page and assert created configurable product");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Select first configurable product option");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeFirstOption', 'option[store_labels][0][label]', 'test')); // stepKey: selectOptionOne
		$I->comment("Assert regular and special price after selecting the first option");
		$I->comment("Entering Action Group [assertStorefrontProductPricesForFirstOption] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertStorefrontProductPricesForFirstOption
		$I->see($I->retrieveEntityField('createFirstConfigChildProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertStorefrontProductPricesForFirstOption
		$I->see("99.99", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertStorefrontProductPricesForFirstOption
		$I->comment("Exiting Action Group [assertStorefrontProductPricesForFirstOption] AssertStorefrontProductPricesActionGroup");
		$I->comment("Select second configurable product option");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('createConfigProductAttributeSecondOption', 'option[store_labels][0][label]', 'test')); // stepKey: selectOptionTwo
		$I->comment("Assert regular and special price after selecting the second option");
		$I->comment("Entering Action Group [assertStorefrontProductPricesForSecondOption] AssertStorefrontProductPricesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAssertStorefrontProductPricesForSecondOption
		$I->see($I->retrieveEntityField('createSecondConfigChildProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: productPriceAmountAssertStorefrontProductPricesForSecondOption
		$I->see("99.99", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: productFinalPriceAmountAssertStorefrontProductPricesForSecondOption
		$I->comment("Exiting Action Group [assertStorefrontProductPricesForSecondOption] AssertStorefrontProductPricesActionGroup");
	}
}
