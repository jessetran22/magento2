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
 * @Title("MC-35954: Create and add new dropdown product attribute to existing set, assign it to existing product with that set and see it on layered navigation")
 * @Description("Verify that new dropdown attribute in existing attribute set shows on layered navigation on storefront without reindex<h3>Test files</h3>app/code/Magento/LayeredNavigation/Test/Mftf/Test/StorefrontFilterableProductAttributeInLayeredNavigationWithoutReindexTest.xml<br>")
 * @TestCaseId("MC-35954")
 * @group layeredNavigation
 * @group SearchEngineElasticsearch
 */
class StorefrontFilterableProductAttributeInLayeredNavigationWithoutReindexTestCest
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
		$I->comment("Create category, attribute set with multiselect product attribute with two options");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
		$I->createEntity("createMultiselectAttribute", "hook", "multipleSelectProductAttribute", [], []); // stepKey: createMultiselectAttribute
		$I->createEntity("firstMultiselectOption", "hook", "ProductAttributeOption10", ["createMultiselectAttribute"], []); // stepKey: firstMultiselectOption
		$I->createEntity("secondMultiselectOption", "hook", "ProductAttributeOption11", ["createMultiselectAttribute"], []); // stepKey: secondMultiselectOption
		$I->getEntity("getFirstMultiselectOption", "hook", "ProductAttributeOptionGetter", ["createMultiselectAttribute"], null, 1); // stepKey: getFirstMultiselectOption
		$I->getEntity("getSecondMultiselectOption", "hook", "ProductAttributeOptionGetter", ["createMultiselectAttribute"], null, 2); // stepKey: getSecondMultiselectOption
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/" . $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook') . "/"); // stepKey: onAttributeSetEdit
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoad
		$I->comment("Entering Action Group [assignMultiselectAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignMultiselectAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignMultiselectAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createMultiselectAttribute', 'attribute_code', 'hook') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignMultiselectAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignMultiselectAttributeToGroup
		$I->see($I->retrieveEntityField('createMultiselectAttribute', 'attribute_code', 'hook'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignMultiselectAttributeToGroup
		$I->comment("Exiting Action Group [assignMultiselectAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Create configurable product with created attribute set and multiselect attribute");
		$createFirstSimpleProductFields['attribute_set_id'] = $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook');
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleOne", ["createMultiselectAttribute", "getFirstMultiselectOption"], $createFirstSimpleProductFields, "all"); // stepKey: createFirstSimpleProduct
		$createSecondSimpleProductFields['attribute_set_id'] = $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook');
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleOne", ["createMultiselectAttribute", "getSecondMultiselectOption"], $createSecondSimpleProductFields, "all"); // stepKey: createSecondSimpleProduct
		$createConfigurableProductFields['attribute_set_id'] = $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook');
		$I->createEntity("createConfigurableProduct", "hook", "BaseConfigurableProduct", ["createCategory"], $createConfigurableProductFields); // stepKey: createConfigurableProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductOneOption", ["createConfigurableProduct", "createMultiselectAttribute", "getFirstMultiselectOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductOption2", "hook", "ConfigurableProductOneOption", ["createConfigurableProduct", "createMultiselectAttribute", "getSecondMultiselectOption"], []); // stepKey: createConfigProductOption2
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createFirstSimpleProduct"], []); // stepKey: createConfigProductAddChild
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createSecondSimpleProduct"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Create new dropdown attribute with two options and set Use in layered navigation \"Filterable (no results)\"");
		$I->createEntity("createDropdownAttribute", "hook", "dropdownProductAttribute", [], []); // stepKey: createDropdownAttribute
		$I->createEntity("firstDropdownOption", "hook", "ProductAttributeOption10", ["createDropdownAttribute"], []); // stepKey: firstDropdownOption
		$I->createEntity("secondDropdownOption", "hook", "ProductAttributeOption11", ["createDropdownAttribute"], []); // stepKey: secondDropdownOption
		$I->getEntity("getFirstDropdownOption", "hook", "ProductAttributeOptionGetter", ["createDropdownAttribute"], null, 1); // stepKey: getFirstDropdownOption
		$I->getEntity("getSecondDropdownOption", "hook", "ProductAttributeOptionGetter", ["createDropdownAttribute"], null, 2); // stepKey: getSecondDropdownOption
		$I->comment("Entering Action Group [goToDropdownAttributePage] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridGoToDropdownAttributePage
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridGoToDropdownAttributePage
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridGoToDropdownAttributePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadGoToDropdownAttributePage
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'hook')); // stepKey: setAttributeCodeGoToDropdownAttributePage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridGoToDropdownAttributePage
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridGoToDropdownAttributePageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearGoToDropdownAttributePage
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'hook') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadGoToDropdownAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadGoToDropdownAttributePageWaitForPageLoad
		$I->see($I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'hook'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridGoToDropdownAttributePage
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'hook') . "')]"); // stepKey: clickAttributeToViewGoToDropdownAttributePage
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewGoToDropdownAttributePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadGoToDropdownAttributePage
		$I->comment("Exiting Action Group [goToDropdownAttributePage] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [setDropdownUseInLayeredNavigationNoResults] AdminSetProductAttributeUseInLayeredNavigationOptionActionGroup");
		$I->conditionalClick("#product_attribute_tabs_front", "#is_filterable", false); // stepKey: clickStoreFrontTabSetDropdownUseInLayeredNavigationNoResults
		$I->waitForElementVisible("#is_filterable", 30); // stepKey: waitForStorefrontTabLoadSetDropdownUseInLayeredNavigationNoResults
		$I->selectOption("#is_filterable", "Filterable (no results)"); // stepKey: selectUseInLayeredNavigationOptionSetDropdownUseInLayeredNavigationNoResults
		$I->comment("Exiting Action Group [setDropdownUseInLayeredNavigationNoResults] AdminSetProductAttributeUseInLayeredNavigationOptionActionGroup");
		$I->comment("Entering Action Group [saveDropdownAttribute] AdminProductAttributeSaveActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageSaveDropdownAttribute
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveDropdownAttributeWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveDropdownAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveDropdownAttribute
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveDropdownAttribute
		$I->comment("Exiting Action Group [saveDropdownAttribute] AdminProductAttributeSaveActionGroup");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createMultiselectAttribute", "hook"); // stepKey: deleteMultiselectAttribute
		$I->deleteEntity("createDropdownAttribute", "hook"); // stepKey: deleteDropdownAttribute
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"LayeredNavigation"})
	 * @Stories({"Product attributes in Layered Navigation"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontFilterableProductAttributeInLayeredNavigationWithoutReindexTest(AcceptanceTester $I)
	{
		$I->comment("Set attribute option Use in layered navigation to \"Filterable(no results)\"");
		$I->comment("Entering Action Group [goToMultiselectAttributePage] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridGoToMultiselectAttributePage
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridGoToMultiselectAttributePage
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridGoToMultiselectAttributePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadGoToMultiselectAttributePage
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createMultiselectAttribute', 'attribute_code', 'test')); // stepKey: setAttributeCodeGoToMultiselectAttributePage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridGoToMultiselectAttributePage
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridGoToMultiselectAttributePageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearGoToMultiselectAttributePage
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createMultiselectAttribute', 'attribute_code', 'test') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadGoToMultiselectAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadGoToMultiselectAttributePageWaitForPageLoad
		$I->see($I->retrieveEntityField('createMultiselectAttribute', 'attribute_code', 'test'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridGoToMultiselectAttributePage
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createMultiselectAttribute', 'attribute_code', 'test') . "')]"); // stepKey: clickAttributeToViewGoToMultiselectAttributePage
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewGoToMultiselectAttributePageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadGoToMultiselectAttributePage
		$I->comment("Exiting Action Group [goToMultiselectAttributePage] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [setMultiselectUseInLayeredNavigationNoResults] AdminSetProductAttributeUseInLayeredNavigationOptionActionGroup");
		$I->conditionalClick("#product_attribute_tabs_front", "#is_filterable", false); // stepKey: clickStoreFrontTabSetMultiselectUseInLayeredNavigationNoResults
		$I->waitForElementVisible("#is_filterable", 30); // stepKey: waitForStorefrontTabLoadSetMultiselectUseInLayeredNavigationNoResults
		$I->selectOption("#is_filterable", "Filterable (no results)"); // stepKey: selectUseInLayeredNavigationOptionSetMultiselectUseInLayeredNavigationNoResults
		$I->comment("Exiting Action Group [setMultiselectUseInLayeredNavigationNoResults] AdminSetProductAttributeUseInLayeredNavigationOptionActionGroup");
		$I->comment("Entering Action Group [saveMultiselectAttribute] AdminProductAttributeSaveActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageSaveMultiselectAttribute
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveMultiselectAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveMultiselectAttributeWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveMultiselectAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveMultiselectAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveMultiselectAttribute
		$I->see("You saved the product attribute.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveMultiselectAttribute
		$I->comment("Exiting Action Group [saveMultiselectAttribute] AdminProductAttributeSaveActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createMultiselectAttribute', 'default_frontend_label', 'test') . "')]", 30); // stepKey: waitForMultiselectAttributeVisible
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createMultiselectAttribute', 'default_frontend_label', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttribute
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForMultiselectAttributeOptionsVisible
		$I->seeElement("//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('getFirstMultiselectOption', 'label', 'test') . "')]"); // stepKey: assertMultiselectAttributeFirstOptionInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertMultiselectAttributeFirstOptionInLayeredNavigationWaitForPageLoad
		$I->seeElement("//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('getSecondMultiselectOption', 'label', 'test') . "')]"); // stepKey: assertMultiselectAttributeSecondOptionInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertMultiselectAttributeSecondOptionInLayeredNavigationWaitForPageLoad
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/" . $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'test') . "/"); // stepKey: onAttributeSetEditPage
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetEditPageLoad
		$I->comment("Entering Action Group [assignDropdownAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignDropdownAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignDropdownAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'test') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignDropdownAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignDropdownAttributeToGroup
		$I->see($I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignDropdownAttributeToGroup
		$I->comment("Exiting Action Group [assignDropdownAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveAttributeSetWithDropdownAttribute] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSetWithDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWithDropdownAttributeWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSetWithDropdownAttribute
		$I->comment("Exiting Action Group [saveAttributeSetWithDropdownAttribute] SaveAttributeSetActionGroup");
		$I->comment("Assign dropdown attribute to child product of configurable");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFirstSimpleProduct', 'id', 'test')); // stepKey: visitAdminEditProductPage
		$I->waitForElementVisible("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'test') . "]']", 30); // stepKey: waitForDropdownAttributeSelectVisible
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute_code', 'test') . "]']", $I->retrieveEntityField('getFirstDropdownOption', 'label', 'test')); // stepKey: selectValueOfNewAttribute
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Assert that dropdown attribute is present on layered navigation with both options");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadWithDropdownAttribute
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'test') . "')]", 30); // stepKey: waitForDropdownAttributeVisible
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createDropdownAttribute', 'default_frontend_label', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandDropdownAttribute
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForDropdownAttributeOptionsVisible
		$I->seeElement("//div[@class='filter-options']//li[@class='item']//a[contains(text(), '" . $I->retrieveEntityField('getFirstDropdownOption', 'label', 'test') . "')]"); // stepKey: assertDropdownAttributeFirstOptionInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertDropdownAttributeFirstOptionInLayeredNavigationWaitForPageLoad
		$I->seeElement("//div[@class='filter-options']//li[@class='item' and contains(text(), '" . $I->retrieveEntityField('getSecondDropdownOption', 'label', 'test') . "')]"); // stepKey: assertDropdownAttributeSecondOptionInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertDropdownAttributeSecondOptionInLayeredNavigationWaitForPageLoad
	}
}
