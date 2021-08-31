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
 * @Title("MC-63: Admin should be able to remove a product configuration")
 * @Description("Admin should be able to remove a product configuration<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductUpdateTest/AdminConfigurableProductRemoveAnOptionTest.xml<br>")
 * @TestCaseId("MC-63")
 * @group ConfigurableProduct
 */
class AdminConfigurableProductRemoveAnOptionTestCest
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
		$I->comment("This was copied and modified from the EndToEndB2CGuestUserTest");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
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
	 * @Stories({"Create, Read, Update, Delete"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableProductRemoveAnOptionTest(AcceptanceTester $I)
	{
		$I->comment("check storefront for both options");
		$I->comment("Entering Action Group [amOnStorefront1] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAmOnStorefront1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedAmOnStorefront1
		$I->comment("Exiting Action Group [amOnStorefront1] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeOption1Storefront] AssertStorefrontProductAttributeOptionVisibleActionGroup");
		$I->see("option1", "#product-options-wrapper div[tabindex='0'] option"); // stepKey: seeProductAttributeOptionSeeOption1Storefront
		$I->comment("Exiting Action Group [seeOption1Storefront] AssertStorefrontProductAttributeOptionVisibleActionGroup");
		$I->comment("Entering Action Group [seeOption2Storefront] AssertStorefrontProductAttributeOptionVisibleActionGroup");
		$I->see("option2", "#product-options-wrapper div[tabindex='0'] option"); // stepKey: seeProductAttributeOptionSeeOption2Storefront
		$I->comment("Exiting Action Group [seeOption2Storefront] AssertStorefrontProductAttributeOptionVisibleActionGroup");
		$I->comment("check admin for both options");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'test')); // stepKey: goToProductGoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->comment("Entering Action Group [seeOption1Admin] AssertAdminChildProductDataOnParentProductEditPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'name', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeChildProductDataSeeOption1Admin
		$I->comment("Exiting Action Group [seeOption1Admin] AssertAdminChildProductDataOnParentProductEditPageActionGroup");
		$I->comment("Entering Action Group [seeOption2Admin] AssertAdminChildProductDataOnParentProductEditPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'name', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeChildProductDataSeeOption2Admin
		$I->comment("Exiting Action Group [seeOption2Admin] AssertAdminChildProductDataOnParentProductEditPageActionGroup");
		$I->comment("remove an option");
		$I->click("(//button[@class='action-select']/span[contains(text(), 'Select')])[1]"); // stepKey: clickToExpandActions
		$I->click("//a[text()='Remove Product']"); // stepKey: clickRemove
		$I->comment("Entering Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSave
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSave
		$I->comment("Exiting Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->comment("check admin for one option");
		$I->dontSee($I->retrieveEntityField('createConfigChildProduct1', 'name', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: dontSeeOption1Admin
		$I->comment("check storefront for one option");
		$I->comment("Entering Action Group [amOnStorefront2] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAmOnStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedAmOnStorefront2
		$I->comment("Exiting Action Group [amOnStorefront2] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->dontSee("option1", "#product-options-wrapper div[tabindex='0'] option"); // stepKey: dontSeeOption1InStorefront
		$I->comment("Entering Action Group [seeOption2Again] AssertStorefrontProductAttributeOptionVisibleActionGroup");
		$I->see("option2", "#product-options-wrapper div[tabindex='0'] option"); // stepKey: seeProductAttributeOptionSeeOption2Again
		$I->comment("Exiting Action Group [seeOption2Again] AssertStorefrontProductAttributeOptionVisibleActionGroup");
	}
}
