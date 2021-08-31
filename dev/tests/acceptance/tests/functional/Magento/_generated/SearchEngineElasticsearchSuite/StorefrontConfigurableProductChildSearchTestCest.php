<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-249: Guest customer should be able to search configurable product by attributes of child products")
 * @Description("Guest customer should be able to search configurable product by attributes of child products<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontConfigurableProductChildSearchTest.xml<br>")
 * @TestCaseId("MC-249")
 * @group ConfigurableProduct
 * @group SearchEngineElasticsearch
 */
class StorefrontConfigurableProductChildSearchTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("TODO: This should be converted to an actionGroup once MQE-993 is fixed.");
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product and add it to the category");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->comment("Create an attribute with two options to be used in the second child product");
		$I->createEntity("createConfigProductAttributeMultiSelect", "hook", "productAttributeMultiselectTwoOptions", [], []); // stepKey: createConfigProductAttributeMultiSelect
		$I->createEntity("createConfigProductAttributeOption1Multiselect", "hook", "productAttributeOption3", ["createConfigProductAttributeMultiSelect"], []); // stepKey: createConfigProductAttributeOption1Multiselect
		$I->createEntity("createConfigProductAttributeOption2Multiselect", "hook", "productAttributeOption4", ["createConfigProductAttributeMultiSelect"], []); // stepKey: createConfigProductAttributeOption2Multiselect
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Add the second attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet2", "hook", "AddToDefaultSet", ["createConfigProductAttributeMultiSelect"], []); // stepKey: createConfigAddToAttributeSet2
		$I->comment("Get the first option of the attribute we created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Get the first option of the second attribute we created");
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeMultiSelect"], null, 1); // stepKey: getConfigAttributeOption2
		$I->comment("Create a simple product and give it the attribute with the first option");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOneHidden", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->updateEntity("createConfigChildProduct1", "hook", "ApiSimpleProductUpdateDescription",[]); // stepKey: updateSimpleProduct1
		$I->comment("Create a simple product and give it the attribute with the second option");
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwoHidden", ["createConfigProductAttributeMultiSelect", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Add the second simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Create an attribute with two options to be used in the first child product (in the UI)");
		$I->createEntity("createConfigProductAttributeSelect", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeSelect
		$I->createEntity("createConfigProductAttributeSelectOption1", "hook", "productAttributeOption5", ["createConfigProductAttributeSelect"], []); // stepKey: createConfigProductAttributeSelectOption1
		$I->createEntity("createConfigProductAttributeSelectOption2", "hook", "productAttributeOption6", ["createConfigProductAttributeSelect"], []); // stepKey: createConfigProductAttributeSelectOption2
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet3", "hook", "AddToDefaultSet", ["createConfigProductAttributeSelect"], []); // stepKey: createConfigAddToAttributeSet3
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Go to the product page for the first product");
		$I->comment("Entering Action Group [goToProductGrid] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductGrid
		$I->comment("Exiting Action Group [goToProductGrid] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [searchForSimpleProduct] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchForSimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersSearchForSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigChildProduct1', 'sku', 'hook')); // stepKey: fillProductSkuFilterSearchForSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersSearchForSimpleProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadSearchForSimpleProduct
		$I->comment("Exiting Action Group [searchForSimpleProduct] FilterProductGridBySku2ActionGroup");
		$I->comment("Entering Action Group [openProductEditPage] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProductEditPage
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProductEditPageWaitForPageLoad
		$I->comment("Exiting Action Group [openProductEditPage] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Edit the attribute for the first simple product");
		$I->selectOption("//*[text()='" . $I->retrieveEntityField('createConfigProductAttributeSelect', 'default_frontend_label', 'hook') . "']/../../..//select", $I->retrieveEntityField('createConfigProductAttributeSelectOption1', 'option[store_labels][0][label]', 'hook')); // stepKey: editSelectAttribute
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccess
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createConfigProductAttributeMultiSelect", "hook"); // stepKey: deleteConfigProductAttributeMultiSelect
		$I->deleteEntity("createConfigProductAttributeSelect", "hook"); // stepKey: deleteConfigProductAttributeSelect
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteApiCategory
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"View configurable product details in storefront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductChildSearchTest(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Quick search the storefront for the first attribute option");
		$I->comment("Entering Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStoreFront
		$I->comment("Exiting Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createConfigProductAttributeSelectOption1', 'option[store_labels][0][label]', 'test')]); // stepKey: searchStorefront1
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: seeProduct1
		$I->comment("Quick search the storefront for the second attribute option");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createConfigProductAttributeOption1Multiselect', 'option[store_labels][0][label]', 'test')]); // stepKey: searchStorefront2
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: seeProduct2
		$I->comment("Quick search the storefront for the first product description");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createConfigChildProduct1', 'custom_attributes[short_description]', 'test')]); // stepKey: searchStorefront3
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: seeProduct3
	}
}
