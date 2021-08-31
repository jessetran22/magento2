<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/5034526: DEPRECATED. User Edits Category from Category grid")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/5034526")
 * @Description("Edit Category from Media Gallery Category Grid<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminMediaGalleryCatalogUiEditCategoryFromGridPageTest instead</li></ul><h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiEditCategoryGridPageTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiEditCategoryGridPageTestCest
{
	/**
	 * @Features({"MediaGalleryCatalogUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCatalogUiEditCategoryGridPageTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminMediaGalleryCatalogUiEditCategoryFromGridPageTest instead");
	}
}
