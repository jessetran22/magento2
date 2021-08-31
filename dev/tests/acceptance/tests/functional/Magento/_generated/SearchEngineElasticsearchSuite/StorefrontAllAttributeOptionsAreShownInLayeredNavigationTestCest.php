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
 * @Title("MC-28963: Limitation of displayed attribute options number in layered navigation with ElasticSearch")
 * @Description("All attribute options are shown in Layered navigation<h3>Test files</h3>app/code/Magento/LayeredNavigation/Test/Mftf/Test/StorefrontAllAttributeOptionsAreShownInLayeredNavigationTest.xml<br>")
 * @TestCaseId("MC-28963")
 * @group layeredNavigation
 * @group catalog
 * @group SearchEngineElasticsearch
 */
class StorefrontAllAttributeOptionsAreShownInLayeredNavigationTestCest
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
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$enableDisplayProductCount = $I->magentoCLI("config:set catalog/layered_navigation/display_product_count 1", 60); // stepKey: enableDisplayProductCount
		$I->comment($enableDisplayProductCount);
		$setPriceNavigationStepCalculationDefaultValue = $I->magentoCLI("config:set catalog/layered_navigation/price_range_calculation auto", 60); // stepKey: setPriceNavigationStepCalculationDefaultValue
		$I->comment($setPriceNavigationStepCalculationDefaultValue);
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create an attribute");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->comment("Create 15 attribute options");
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->createEntity("createConfigProductAttributeOption4", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption4
		$I->createEntity("createConfigProductAttributeOption5", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption5
		$I->createEntity("createConfigProductAttributeOption6", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption6
		$I->createEntity("createConfigProductAttributeOption7", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption7
		$I->createEntity("createConfigProductAttributeOption8", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption8
		$I->createEntity("createConfigProductAttributeOption9", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption9
		$I->createEntity("createConfigProductAttributeOption10", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption10
		$I->createEntity("createConfigProductAttributeOption11", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption11
		$I->createEntity("createConfigProductAttributeOption12", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption12
		$I->createEntity("createConfigProductAttributeOption13", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption13
		$I->createEntity("createConfigProductAttributeOption14", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption14
		$I->createEntity("createConfigProductAttributeOption15", "hook", "productAttributeOption", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption15
		$I->comment("Get Created options data");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$I->getEntity("getConfigAttributeOption4", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 4); // stepKey: getConfigAttributeOption4
		$I->getEntity("getConfigAttributeOption5", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 5); // stepKey: getConfigAttributeOption5
		$I->getEntity("getConfigAttributeOption6", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 6); // stepKey: getConfigAttributeOption6
		$I->getEntity("getConfigAttributeOption7", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 7); // stepKey: getConfigAttributeOption7
		$I->getEntity("getConfigAttributeOption8", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 8); // stepKey: getConfigAttributeOption8
		$I->getEntity("getConfigAttributeOption9", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 9); // stepKey: getConfigAttributeOption9
		$I->getEntity("getConfigAttributeOption10", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 10); // stepKey: getConfigAttributeOption10
		$I->getEntity("getConfigAttributeOption11", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 11); // stepKey: getConfigAttributeOption11
		$I->getEntity("getConfigAttributeOption12", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 12); // stepKey: getConfigAttributeOption12
		$I->getEntity("getConfigAttributeOption13", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 13); // stepKey: getConfigAttributeOption13
		$I->getEntity("getConfigAttributeOption14", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 14); // stepKey: getConfigAttributeOption14
		$I->getEntity("getConfigAttributeOption15", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 15); // stepKey: getConfigAttributeOption15
		$I->comment("Add attribute to attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Create Configurable product");
		$I->createEntity("createConfigProduct", "hook", "BaseConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create simple products and set them created attribute value");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption1", "createCategory"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption2", "createCategory"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption3", "createCategory"], []); // stepKey: createConfigChildProduct3
		$I->createEntity("createConfigChildProduct4", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption4", "createCategory"], []); // stepKey: createConfigChildProduct4
		$I->createEntity("createConfigChildProduct5", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption5", "createCategory"], []); // stepKey: createConfigChildProduct5
		$I->createEntity("createConfigChildProduct6", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption6", "createCategory"], []); // stepKey: createConfigChildProduct6
		$I->createEntity("createConfigChildProduct7", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption7", "createCategory"], []); // stepKey: createConfigChildProduct7
		$I->createEntity("createConfigChildProduct8", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption8", "createCategory"], []); // stepKey: createConfigChildProduct8
		$I->createEntity("createConfigChildProduct9", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption9", "createCategory"], []); // stepKey: createConfigChildProduct9
		$I->createEntity("createConfigChildProduct10", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption10", "createCategory"], []); // stepKey: createConfigChildProduct10
		$I->createEntity("createConfigChildProduct11", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption11", "createCategory"], []); // stepKey: createConfigChildProduct11
		$I->createEntity("createConfigChildProduct12", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption12", "createCategory"], []); // stepKey: createConfigChildProduct12
		$I->createEntity("createConfigChildProduct13", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption13", "createCategory"], []); // stepKey: createConfigChildProduct13
		$I->createEntity("createConfigChildProduct14", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption14", "createCategory"], []); // stepKey: createConfigChildProduct14
		$I->createEntity("createConfigChildProduct15", "hook", "ApiSimpleProductWithCategory", ["createConfigProductAttribute", "getConfigAttributeOption15", "createCategory"], []); // stepKey: createConfigChildProduct15
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProduct15Options", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3", "getConfigAttributeOption4", "getConfigAttributeOption5", "getConfigAttributeOption6", "getConfigAttributeOption7", "getConfigAttributeOption8", "getConfigAttributeOption9", "getConfigAttributeOption10", "getConfigAttributeOption11", "getConfigAttributeOption12", "getConfigAttributeOption13", "getConfigAttributeOption14", "getConfigAttributeOption15"], []); // stepKey: createConfigProductOption
		$I->comment("Add simple products to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
		$I->createEntity("createConfigProductAddChild4", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct4"], []); // stepKey: createConfigProductAddChild4
		$I->createEntity("createConfigProductAddChild5", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct5"], []); // stepKey: createConfigProductAddChild5
		$I->createEntity("createConfigProductAddChild6", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct6"], []); // stepKey: createConfigProductAddChild6
		$I->createEntity("createConfigProductAddChild7", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct7"], []); // stepKey: createConfigProductAddChild7
		$I->createEntity("createConfigProductAddChild8", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct8"], []); // stepKey: createConfigProductAddChild8
		$I->createEntity("createConfigProductAddChild9", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct9"], []); // stepKey: createConfigProductAddChild9
		$I->createEntity("createConfigProductAddChild10", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct10"], []); // stepKey: createConfigProductAddChild10
		$I->createEntity("createConfigProductAddChild11", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct11"], []); // stepKey: createConfigProductAddChild11
		$I->createEntity("createConfigProductAddChild12", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct12"], []); // stepKey: createConfigProductAddChild12
		$I->createEntity("createConfigProductAddChild13", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct13"], []); // stepKey: createConfigProductAddChild13
		$I->createEntity("createConfigProductAddChild14", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct14"], []); // stepKey: createConfigProductAddChild14
		$I->createEntity("createConfigProductAddChild15", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct15"], []); // stepKey: createConfigProductAddChild15
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigChildProduct4", "hook"); // stepKey: deleteConfigChildProduct4
		$I->deleteEntity("createConfigChildProduct5", "hook"); // stepKey: deleteConfigChildProduct5
		$I->deleteEntity("createConfigChildProduct6", "hook"); // stepKey: deleteConfigChildProduct6
		$I->deleteEntity("createConfigChildProduct7", "hook"); // stepKey: deleteConfigChildProduct7
		$I->deleteEntity("createConfigChildProduct8", "hook"); // stepKey: deleteConfigChildProduct8
		$I->deleteEntity("createConfigChildProduct9", "hook"); // stepKey: deleteConfigChildProduct9
		$I->deleteEntity("createConfigChildProduct10", "hook"); // stepKey: deleteConfigChildProduct10
		$I->deleteEntity("createConfigChildProduct11", "hook"); // stepKey: deleteConfigChildProduct11
		$I->deleteEntity("createConfigChildProduct12", "hook"); // stepKey: deleteConfigChildProduct12
		$I->deleteEntity("createConfigChildProduct13", "hook"); // stepKey: deleteConfigChildProduct13
		$I->deleteEntity("createConfigChildProduct14", "hook"); // stepKey: deleteConfigChildProduct14
		$I->deleteEntity("createConfigChildProduct15", "hook"); // stepKey: deleteConfigChildProduct15
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteAttribute
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
	 * @Features({"LayeredNavigation"})
	 * @Stories({"Product attributes in Layered Navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAllAttributeOptionsAreShownInLayeredNavigationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Check filtration options for created attribute. All attribute options should be displayed");
		$I->comment("Entering Action Group [assertAttributeOption1PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption1PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption1PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption1PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test'), ".filter-options-item.active .items li:nth-child(1) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption1PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption1PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption1PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption2PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption2PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption2PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption2PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test'), ".filter-options-item.active .items li:nth-child(2) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption2PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption2PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption2PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption3PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption3PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption3PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption3PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption3', 'label', 'test'), ".filter-options-item.active .items li:nth-child(3) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption3PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption3PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption3PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption4PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption4PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption4PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption4PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption4', 'label', 'test'), ".filter-options-item.active .items li:nth-child(4) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption4PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption4PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption4PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption5PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption5PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption5PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption5PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption5', 'label', 'test'), ".filter-options-item.active .items li:nth-child(5) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption5PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption5PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption5PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption6PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption6PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption6PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption6PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption6', 'label', 'test'), ".filter-options-item.active .items li:nth-child(6) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption6PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption6PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption6PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption7PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption7PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption7PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption7PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption7', 'label', 'test'), ".filter-options-item.active .items li:nth-child(7) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption7PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption7PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption7PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption8PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption8PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption8PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption8PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption8', 'label', 'test'), ".filter-options-item.active .items li:nth-child(8) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption8PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption8PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption8PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption9PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption9PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption9PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption9PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption9', 'label', 'test'), ".filter-options-item.active .items li:nth-child(9) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption9PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption9PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption9PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption10PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption10PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption10PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption10PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption10', 'label', 'test'), ".filter-options-item.active .items li:nth-child(10) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption10PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption10PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption10PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption11PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption11PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption11PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption11PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption11', 'label', 'test'), ".filter-options-item.active .items li:nth-child(11) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption11PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption11PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption11PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption12PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption12PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption12PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption12PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption12', 'label', 'test'), ".filter-options-item.active .items li:nth-child(12) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption12PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption12PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption12PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption13PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption13PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption13PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption13PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption13', 'label', 'test'), ".filter-options-item.active .items li:nth-child(13) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption13PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption13PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption13PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption14PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption14PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption14PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption14PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption14', 'label', 'test'), ".filter-options-item.active .items li:nth-child(14) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption14PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption14PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption14PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertAttributeOption15PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeOption15PresentInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeOption15PresentInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeOption15PresentInLayeredNavigation
		$I->see($I->retrieveEntityField('getConfigAttributeOption15', 'label', 'test'), ".filter-options-item.active .items li:nth-child(15) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption15PresentInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeOption15PresentInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeOption15PresentInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
	}
}
